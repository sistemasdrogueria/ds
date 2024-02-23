<style>
*{ margin: 0; padding: 0; box-sizing: border-box;}
.menu_delia{margin-bottom: 5px;}
nav{ height: 50px; text-align: center;}
nav ul{ list-style: none; display: inline-block; padding:0px; }
nav ul li{ float: left; /*margin-top: 20px;*/}
nav ul li a { color: #000; font-weight: bold; text-decoration: none; font-size: 20px; padding: 15px;}
nav ul li a:hover{ background-color: #000; border-radius: 6px; }
</style>
<div class=menu_delia >
<nav>
<ul>
<li><?= $this->Html->link(__('FRAGANCIAS'), ['controller' => 'DeliaPerfumerias', 'action' => 'fragancia']) ?></li>
<li><?= $this->Html->link(__('DERMO'), ['controller' => 'DeliaPerfumerias', 'action' => 'dermo']) ?></li>

<li><?= $this->Html->link(__('ESTETICA'), ['controller' => 'DeliaPerfumerias', 'action' => 'estetica']) ?></li>
<li><?= $this->Html->link(__('SOLARES'), ['controller' => 'DeliaPerfumerias', 'action' => 'solares']) ?></li>

<li><?= $this->Html->link(__('MAKE UP'), ['controller' => 'DeliaPerfumerias', 'action' => 'makeup']) ?></li >
</ul>
</nav>
</div>