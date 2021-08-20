<?php
/**
 * 工厂方法模式
 * 对接口进行编程，创建的是接口，具体实现的类可创建不同的类对象
 *
 * 在基于类的编程中，工厂方法模式是一种创建模式，它使用工厂方法来处理创建对象的问题，
 * 而无需指定将要创建的对象的确切类。这是通过调用工厂方法来创建对象来完成的 - 
 * 在接口中指定并由子类实现，或者在基类中实现并可选地由派生类覆盖 - 而不是通过调用构造函数。
 */
// 1. 需要一个接口，用于指定必须实现的功能接口，可具体编写多个子类来实现
interface Sms
{
	public function send(string $mobile, string $message);
}
// 1.1. 子类1实现接口
class AliSms implements Sms
{
	public function send(string $mobile, string $message)
	{
		echo "use Ali send sms" . PHP_EOL;
	}
}
// 1.2. 子类2实现接口
class TencentSms implements Sms
{
	public function send(string $mobile, string $message)
	{
		echo "use Tencent send sms" . PHP_EOL;
	}
}


// 2. 需要一个工厂方法接口，规定创建上面的接口，创建具体类的接口由其他类来实现接口
interface SmsFactory
{
	public function createSms() : Sms;
}
// 2.1. 子工厂1创建子类1对象，实现工厂方法接口
class AliSmsFactory
{
	public function createSms() : Sms
	{
		return new AliSms();
	}
}
// 2.1. 子工厂2创建子类2对象，实现工厂方法接口
class TencentSmsFactory
{
	public function createSms() : Sms
	{
		return new TencentSms();
	}
}

echo "run factoryMethod.php" . PHP_EOL;
$ali = new AliSmsFactory();
$ali->createSms()->send('', '');

$tencent = new TencentSmsFactory();
$tencent->createSms()->send('', '');