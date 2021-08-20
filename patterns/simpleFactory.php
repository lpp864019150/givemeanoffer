<?php
/*
 * 通过工厂获取对象，无需直接实例化对象
 * 简单工厂只是为客户端生成一个实例，而不会向客户端公开任何实例化逻辑
 * 在面向对象编程（OOP）中，工厂是用于创建其他对象的对象 - 正式工厂是一种函数或方法，它从一些方法调用返回变化的原型或类的对象，这被假定为“新”。
 */
 class SimpleFactory
 {
 	// 使用工厂获取对象，在获取对象时可以做一些额外的逻辑
 	public function createBicycle(string $color) : Bicycle
 	{
 		// do something ...
 		return new Bicycle($color);
 	}
 }

 class Bicycle
 {
 	private $color;

 	public function __construct(string $color)
 	{
 		$this->color = $color;
 	}

 	public function getColor()
 	{
 		return $this->color;
 	}
 }

 echo "run simpleFactory.php" . PHP_EOL;
 $f = new SimpleFactory();
 $b = $f->createBicycle('red');
 echo $b->getColor() . PHP_EOL;