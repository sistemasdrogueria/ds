<?php
namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\Event\Event;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class UploadBehavior extends Behavior
{
	/**
	 * Default config.
	 *
	 * @var array
	 */
	public $_defaultConfig = [
		'root'   => WWW_ROOT,
		'suffix' => '_file',
		'fields' => []
	];

	/**
	 * Table instance.
	 *
	 * @var \Cake\ORM\Table
	 */
	protected $_table;

	/**
	 * Folder instance.
	 *
	 * @var \Cake\Filesystem\Folder
	 */
	protected $_folder;

	/**
	 * Overwrite old file on upload.
	 *
	 * @var bool
	 */
	private $_overwrite = true;

	/**
	 * The prefix of the file.
	 *
	 * @var bool|string
	 */
	private $_prefix = false;

	/**
	 * The default file of the field.
	 *
	 * @var bool|string
	 */
	private $_defaultFile = false;

	/**
	 * Constructor.
	 *
	 * @param \Cake\ORM\Table $table  The table this behavior is attached to.
	 * @param array           $config The config for this behavior.
	 */
	public function __construct(Table $table, array $config = [])
	{
		parent::__construct($table, $config);
		$this->_table = $table;
		/**
		 * Instance the Folder with the root configuration.
		 */
		$this->_folder = new Folder($this->_config['root']);
	}

	/**
	 * Check if there is some files to upload and modify the entity before
	 * it is saved.
	 *
	 * For each files to upload, unset their "virtual" property.
	 *
	 * @param Event  $event  The beforeSave event that was fired.
	 * @param Entity $entity The entity that is going to be saved.
	 *
	 * @throws \ErrorException
	 */
	public function beforeSave(Event $event, Entity $entity)
	{
		$config = $this->_config;

		/**
		 * Foreach file set in the configuration, do the upload.
		 */
		foreach ($config['fields'] as $field => $fieldOption)
		{
			$data         = $entity->toArray();
			$virtualField = $field . $config['suffix'];

			/**
			 * Check if the "virtual" field is in the data array and if this
			 * field have a name param. (This is only for check if its a file type.)
			 */
			if (
				isset($data[$virtualField]) &&
				!empty($data[$virtualField]['name'])
			)
			{
				//Get the array (name, tmp_name etc) of the virtual field.
				$file = $entity->get($virtualField);

				/**
				 * If the tmp_name is empty, that mean there was an error while uploading
				 * the file in the temporary directory.
				 */
				if (empty($file['tmp_name']))
				{
					continue;
				}

				if(!isset($fieldOption['path']))
				{
					throw new \ErrorException(__('Error to get the path for the {0} field.', $field));
				}

				/**
				 * Check if the user has set an option for the prefix, else use the default prefix config.
				 */
				if (
					isset($fieldOption['prefix']) &&
					(is_bool($fieldOption['prefix']) || is_string($fieldOption['prefix']))
				)
				{
					$this->_prefix = $fieldOption['prefix'];
				}

				/**
				 * Get the upload path with identifiers replaced by their corresponding folders.
				 */
				$uploadPath = $this->getUploadPath($entity, $fieldOption['path'], (new File($file['name'], false))->ext());

				if (!$uploadPath)
				{
					throw new \ErrorException(__('Error to get the uploadPath.'));
				}

				/**
				 * Create the folders if it doesn't exist.
				 */
				$this->_folder->create(dirname($uploadPath), 0755);

				/**
				 * Try to move the temporary file to the correct upload path.
				 */
				if ($this->moveFile($entity, $file['tmp_name'], $uploadPath, $fieldOption, $field))
				{
					if(!$this->_prefix)
					{
						$this->_prefix = '';
					}
					/**
					 * Set the new value for the current field.
					 */
					$entity->set($field, $this->_prefix . $uploadPath);

				}
			}

			/**
			 * Unset the virtual field from the Entity.
			 */
			$entity->unsetProperty($virtualField);
		}

	}

	/**
	 * Move the temporary source file to the destination file.
	 *
	 * @param \Cake\ORM\Entity $entity      The entity that is going to be saved.
	 * @param string           $source      The temporary source file to copy.
	 * @param string           $destination The destination file to copy.
	 * @param array            $options     The configuration options defined by the user.
	 * @param string           $field       The current field to process.
	 *
	 * @return bool
	 */
	private function moveFile(Entity $entity, $source = '', $destination = '', array $options = [], $field)
	{
		if (empty($source) || empty($destination))
		{
			return false;
		}

		/**
		 * Check if the user has set an option for the overwrite.
		 */
		if (isset($options['overwrite']) && is_bool($options['overwrite']))
		{
			$this->_overwrite = $options['overwrite'];
		}

		/**
		 * Instance the File.
		 */
		$file = new File($source, false, 0755);

		/**
		 * If you have set the overwrite to true, then we must delete the old upload file.
		 */
		if ($this->_overwrite)
		{
			$this->deleteOldUpload($entity, $field, $options, $destination);
		}

		/**
		 * The copy function will overwrite the old file only if this file have the same
		 * name as the old file.
		 */
		if ($file->copy($destination, $this->_overwrite))
		{
			return true;
		}

		return false;
	}

	/**
	 * Delete the old upload file before to save the new file.
	 *
	 * We can not just rely on the copy file with the overwrite, because if you use
	 * an identifier like :md5 (Who use a different name for each file), the copy
	 * function will not delete the old file.
	 *
	 * @param \Cake\ORM\Entity $entity  The entity that is going to be saved.
	 * @param string           $field   The current field to process.
	 * @param array            $options The configuration options defined by the user.
	 * @param string           $newFile The new file path.
	 *
	 * @return bool
	 */
	private function deleteOldUpload(Entity $entity, $field = '', array $options = [], $newFile)
	{
		$fileInfo    = pathinfo($entity->$field);
		$newFileInfo = pathinfo($newFile);

		/**
		 * Check if the user has set an option for the defaultFile, else use the default defaultFile config.
		 */
		if (
			isset($options['defaultFile']) &&
			(is_bool($options['defaultFile']) || is_string($options['defaultFile']))
		)
		{
			$this->_defaultFile = $options['defaultFile'];
		}

		/**
		 * If the old file have the same name as the new file, let the copy
		 * function do the overwrite.
		 *
		 * Or if the old file have the same name as the defaultFile, do not delete it.
		 * For example, if you use a default_avatar.png for all new members, this condition
		 * will make sure that the default_avatar.png will not be deleted.
		 *
		 */
		if (
			$fileInfo['basename'] == $newFileInfo['basename'] ||
			$fileInfo['basename'] == $this->_defaultFile
		)
		{
			return true;
		}

		if ($this->_prefix)
		{
			/**
			 * Replace the prefix. This is useful when you use a custom directory at the root
			 * of webroot and you use the Html Helper to display your image.
			 *
			 * (Because the Html Helper is pointed to the img/ directory by default)
			 */
			$entity->$field = str_replace($this->_prefix, "", $entity->$field);
		}

		/**
		 * Instance the File.
		 */
		$file = new File($entity->$field, false);

		/**
		 * If the file exist, than delete it.
		 */
		if ($file->exists())
		{
			$file->delete();

			return true;
		}

		return false;
	}

	/**
	 * Get the path formatted without its identifiers to upload the file.
	 *
	 * i.e : upload/:id:/:md5 -> upload/2/5e3e0d0f163196cb9526d97be1b2ce26.jpg
	 *
	 * @param \Cake\ORM\Entity $entity    The entity that is going to be saved.
	 * @param string           $path      The path to upload the file with its identifiers.
	 * @param bool             $extension The extension of the file.
	 *
	 * @return string|void
	 */
	private function getUploadPath(Entity $entity, $path = '', $extension = false)
	{
		if (!$extension || empty($path))
		{
			return false;
		}

		$path = trim($path, '/');

		$identifiers = [
			//Id of the Entity (It can be the user Id if you are in the users table for example)
			':id'  => $entity->id,

			//A random and unique identifier.
			':md5' => md5(rand() . uniqid() . time()),

			//Years, i.e : 2014
			':y'   => date('Y'),

			//Month, i.e : 08
			':m'   => date('m')

		];

		$path = strtr($path, $identifiers) . '.' . strtolower($extension);

		return $path;
	}
}
