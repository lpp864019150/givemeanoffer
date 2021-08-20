<?php
/**
 * 抽象工厂模式
 * 工厂方法的工厂方法
 * 创建类需要同时创建多个子类实例，是工厂方法的升级，创建的这些子类存在依赖关系
 *
 * 抽象工厂模式提供了一种封装一组具有共同主题但没有指定其具体类的单个工厂的方法。
 * 
 * 这里不好找例子，直接拷贝https://github.com/guanguans/design-patterns-for-humans-cn#%E6%8A%BD%E8%B1%A1%E5%B7%A5%E5%8E%82%E6%A8%A1%E5%BC%8Fabstract-factory
 */
// 1. 子类接口1
interface Door
{
    public function getDescription();
}
class WoodenDoor implements Door
{
    public function getDescription()
    {
        echo 'I am a wooden door' . PHP_EOL;
    }
}
class IronDoor implements Door
{
    public function getDescription()
    {
        echo 'I am an iron door' . PHP_EOL;
    }
}

// 2. 子类接口2
interface DoorFittingExpert
{
    public function getDescription();
}
class Welder implements DoorFittingExpert
{
    public function getDescription()
    {
        echo 'I can only fit iron doors' . PHP_EOL;
    }
}
class Carpenter implements DoorFittingExpert
{
    public function getDescription()
    {
        echo 'I can only fit wooden doors' . PHP_EOL;
    }
}

// 3. 创建多个接口，这里需要创建子类接口1、子类接口2
interface DoorFactory
{
    public function makeDoor(): Door;
    public function makeFittingExpert(): DoorFittingExpert;
}
// Wooden factory to return carpenter and wooden door
class WoodenDoorFactory implements DoorFactory
{
    public function makeDoor(): Door
    {
        return new WoodenDoor();
    }

    public function makeFittingExpert(): DoorFittingExpert
    {
        return new Carpenter();
    }
}
// Iron door factory to get iron door and the relevant fitting expert
class IronDoorFactory implements DoorFactory
{
    public function makeDoor(): Door
    {
        return new IronDoor();
    }

    public function makeFittingExpert(): DoorFittingExpert
    {
        return new Welder();
    }
}

// test
echo "run abstractFactory.php" . PHP_EOL;
$woodenFactory = new WoodenDoorFactory();

$door = $woodenFactory->makeDoor();
$expert = $woodenFactory->makeFittingExpert();

$door->getDescription();  // Output: I am a wooden door
$expert->getDescription(); // Output: I can only fit wooden doors

// Same for Iron Factory
$ironFactory = new IronDoorFactory();

$door = $ironFactory->makeDoor();
$expert = $ironFactory->makeFittingExpert();

$door->getDescription();  // Output: I am an iron door
$expert->getDescription(); // Output: I can only fit iron doors