<?php
/**
 * 使应用中只存在一个对象的实例，并且使这个单实例负责所有对该对象的调用。
 * 单例模式已经被考虑列入到反模式中！请使用依赖注入获得更好的代码可测试性和可控性！
 * 
 * eg.
 * 数据库连接器
 * 日志记录器
 * 应用锁文件 （理论上整个应用只有一个锁文件 …）
 */
final class Singleton
{
	private static $instance = null;

	// 必须设置为private，防止外部使用new创建
	private function __construct()
	{
	}

	public static function getInstance() : Singleton
	{
		if (is_null(static::$instance)) static::$instance = new Singleton();

		return static::$instance;
	}

	public function run()
	{
		echo "run something here..." . PHP_EOL;
	}

	// 使用private防止进行clone
	private function __clone() 
	{
	}

	// 防止unserialized
	public function __wakeup()
	{
		throw new Exception("Cannot unserialize singleton");
	}
}

echo "run singleton.php" . PHP_EOL;
//$s = new Singleton();
$s = Singleton::getInstance();
$s->run();