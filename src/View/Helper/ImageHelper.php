<?php
/**
 * Image, image behavior
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Jasper Smet
 * @link          https://github.com/josbeir/image
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Image\View\Helper;

use Cake\View\Helper;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

class ImageHelper extends Helper {

/**
 * [$helpers description]
 * @var [type]
 */
	public $helpers = [ 'Html' ];

/**
 * Paths cache by model
 * @var array
 */
	protected $paths = [];

/**
 * [$_defaultConfig description]
 * @var [type]
 */
	protected $_defaultConfig = [
		'base' => null
	];

/**
 * Render the image as an image tag
 * @param  Cake\ORM\Entity $image
 * @param  array $options Options are passed to HtmlHelper::image (except preset)
 * @return strign Html image tag
 */
	public function render($image, array $options = []) {
		if (empty($image->filename)) {
			return null;
		}

		$preset = null;
		if (isset($options['preset'])) {
			$preset = $options['preset'];
			unset($options['preset']);
		}

		$url = $this->url($image, $preset);

		return $this->Html->image($url, $options);
	}

/**
 * Return the image url
 * @param  Cake\ORM\Entity $image
 * @param  string $preset Optional name of the preset to return
 * @return string Url of the image
 */
	public function url($image, $preset = null) {
		$path = $this->basePath($image);

		if (!empty($preset)) {
			$path .= $preset .'_';
		}

		return $path . $image->filename;
	}

/**
 * Return directory where image is located for given entity
 * @param  Cake\ORM\Entity $image
 * @return string        Base path
 */
	protected function basePath($image) {

		if (isset($this->paths[$image->model])) {
			return $this->paths[$image->model];
		}

		$basePath = $this->config('base');

		// use the path defined in the model's behavior
		if (empty($path)) {
			$table = TableRegistry::get($image->model);
			if ($table->hasBehavior('Image')) {
				$basePath = $table->behaviors()->Image->config('path');
				$basePath = str_replace(WWW_ROOT, '/', $basePath);
				$basePath = str_replace('\\', '/', $basePath); // replace backward slashes with forward
				$basePath = preg_replace('/\/+/', '/', $basePath); // convert multiple slashes into single
			}
		}

		return $this->paths[$image->model] = $basePath . DS . $image->model . DS;
	}

}
