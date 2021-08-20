<?php
/**
 * 原型模式
 *
 * php clone关键字原生支持原型模式 __clone魔术方法可以改变clone
 *
 * 通过创建一个原型对象，然后复制原型对象来避免通过标准的方式创建大量的对象产生的开销(new Foo())。
 * 大量的数据对象(比如通过ORM获取1,000,000行数据库记录然后创建每一条记录对应的对象实体)
 *
 * 原型模式是软件开发中的一种创建型的设计模式。当要创建的对象类型由原型实例确定时使用它，该实例被克隆以生成新对象。
 */
class CloneClass
{
	private static $count;
	// anything

	public function __clone()
	{
		static::$count++;
	}

	public function getCount()
	{
		return static::$count;
	}
}

echo "run clone.php" . PHP_EOL;
$o = new CloneClass();
$another = clone $o;
$third = clone $o;
var_dump($o == $another);

echo "clone count: " . $third->getCount() . PHP_EOL;
