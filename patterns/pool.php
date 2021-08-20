<?php
/**
 * 对象池模式
 * 一般对占用资源的对象，占用时间的资源进行多个初始化，不进行销毁，多次使用
 *
 * 对象池会为你节省宝贵的程序执行时间，比如像数据库连接，socket连接，大量耗费资源的代表数字资源的对象，像字体或者位图。
 * 不过，在特定情况下，简单的对象创建池(没有请求外部的资源，仅仅将自身保存在内存中)或许并不会提升效率和性能，这时候，就需要使用者酌情考虑了。
 */
class Pool
{
	private $current = [];

	private $free = [];

   // 获取对象，可以直接从空闲对象池里返回，若无则创建
	public function get() : DbConnection
	{
		if (count($this->free) == 0) {
			$db = new DbConnection();
		} else {
			$db = array_pop($this->free);
		}

		$this->current[spl_object_hash($db)] = $db;

		return $db;
	}

	// 用完了则进行释放，放入空闲对象池，留给其他程序使用
	public function dispose(DbConnection $db)
	{
		$key = spl_object_hash($db);

		if (isset($this->current[$key])) {
			unset($this->current[$key]);
			$this->free[$key] = $db;
		}
	}

	public function count() : int
	{
		return count($this->current) + count($this->free);
	}
}

class DbConnection
{

}

echo "run pool.php" . PHP_EOL;
$p = new Pool();
$db = $p->get();
$db1 = $p->get();
$p->dispose($db1);
$db2 = $p->get();
echo "count: " . $p->count() . PHP_EOL;