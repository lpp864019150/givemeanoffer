<?php
/**
 * 建造者模式、生成器模式
 * 其实php里面的数组就可以实现构造者
 *
 * 建造者模式是一种创建对象的软件设计模式，其目的是找到伸缩构造器反模式的解决方案。
 *
 * 一般为链式操作 $obj->func1()->func2()->...
 * 
 * public function __construct($size, $cheese = true, $pepperoni = true, $tomato = false, $lettuce = true)
 * {
 * }
 * 参数列表可以使用一个数组代替，或者只把可伸缩参数放入数组$params
 * public function __construct($size, $params = ['cheese' => true, 'pepperoni' => true, 'tomato' => false, 'lettuce' => true])
 * {
 * }
 *
 * 参照https://github.com/guanguans/design-patterns-for-humans-cn#%E5%BB%BA%E9%80%A0%E8%80%85%E6%A8%A1%E5%BC%8F
 */
class Burger
{
    protected $size;

    protected $cheese = false;
    protected $pepperoni = false;
    protected $lettuce = false;
    protected $tomato = false;

    // 传入构建对象，通过构建类来定制各参数
    public function __construct(BurgerBuilder $builder)
    {
        $this->size = $builder->size;
        $this->cheese = $builder->cheese;
        $this->pepperoni = $builder->pepperoni;
        $this->lettuce = $builder->lettuce;
        $this->tomato = $builder->tomato;
    }
}

class BurgerBuilder
{
    public $size;

    public $cheese = false;
    public $pepperoni = false;
    public $lettuce = false;
    public $tomato = false;

    // 必填项必须放入构建方法里
    public function __construct(int $size)
    {
        $this->size = $size;
    }

    public function addPepperoni()
    {
        $this->pepperoni = true;
        return $this;
    }

    public function addLettuce()
    {
        $this->lettuce = true;
        return $this;
    }

    public function addCheese()
    {
        $this->cheese = true;
        return $this;
    }

    public function addTomato()
    {
        $this->tomato = true;
        return $this;
    }

    // 最后构建完成，创建目标类对象
    public function build(): Burger
    {
        return new Burger($this);
    }
}

echo "run builder.php" . PHP_EOL;
$burger = (new BurgerBuilder(14))
                    ->addPepperoni()
                    ->addLettuce()
                    ->addTomato()
                    ->build();


