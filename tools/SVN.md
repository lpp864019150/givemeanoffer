##### 0、
1. [TortoiseSVN打分支、合并分支、切换分支](https://blog.csdn.net/justry_deng/article/details/82259470)
2. [linux下搭建svn服务器及创建项目](https://www.iteye.com/blog/lafecat-1940820)
##### 1、创建项目
0. 安装SVN，若已安装，则跳过
- ```yum install -y subversion```，安装svn
- ```svnserve --version```，检测是否安装，查看版本
1. 创建一个新项目
- ```svnadmin create test_project```，*test_project*为项目名
- 在该项目目录下会生成三个文件 authz、passwd、svnserve.conf
- 公司的操作为，修改svnserve.conf，使用公用的用户与权限文件
- 或者直接使用/data/svn/conf/svnserve.conf进行替换即可，无需编辑
```
# 修改核心配置
anon-access = none # 未鉴权用户，none为拒绝访问
auth-access = write # 鉴权用户，write为可读写
password-db = /data/svn/conf/passwd # 用户密码，可以指定使用特定文件
authz-db = /data/svn/conf/authz # 权限配置，可以指定使用特定文件
# 公司里未用到，这里做过记录
realm：指定版本库的认证域，即在登录时提示的认证域名称。若两个版本库的认证域相同，建议使用相同的用户名口令数据文件
```
- 可以进行分支管理
```
trunk # 主分支，当前发布分支
branches # 一般用来作为并行开发分支
tags # 一般作为稳定版本分支，每次发版都打一个tag分支
dev # 公司里面使用dev目录作为开发分支
```

2. 添加用户
- ```vim /data/svn/conf/passwd```
- 在里面添加一个用户密码即可，user = password
3. 配置权限
- ```vim /data/svn/conf/authz```
- 里面可以配置```[groups]``````[test_project:/]```
```
[groups]
g_admin = user1,user2 # 可以配置一个超级用户组
g_test_project = dev1,dev2,dev3,dev4 # 某个项目作为一个组，配置相应开发

[test_project:/] # 根目录，配置整个项目的权限
@g_admin = rw # groups配置需要在前面加@
@g_test_project = r
test = r # 可以针对单独用户配置
scripts = r

[test_project:/truk] # 可以单独配置
@g_admin = rw

[test_project:/dev]
@g_test_project = rw
```

##### 2、管理SVN服务
1. 启动命令
```
svnserve -d -r /data/svn
-d 表示后台运行，Damon
-r 指定根目录是 /data/svn
```
- 公司的启动配置
```
# 直接在init.d里面进行启动
/etc/init.d svnserve start
/usr/bin/svnserve --foreground --daemon --root=/data/svn
```
2. 停止服务，直接简单粗暴
```
kill -9 pid
/etc/init.d svnserve stop
```
3. 重启
```
/etc/init.d svnserve restart
```

##### 3、客户端使用SVN
1. 下载安装客户端
- 一般下载TortoiseSVN客户端
```
http://tortoisesvn.net/downloads.html
```

2. 在合适的目录下面checkout项目下来
```
1. 进入本地SVN根目录 D:/webroot
2. 右键svn checkout
url: svn://ip/test_project
本地地址：D:/webroot/test_project
```
3. 本地项目与服务端项目就完成了挂钩，在本地进行各种操作可同步到服务端
```
svn co # svn checkout
svn up -r 版本号，可更新到指定版本 # svn update
svn ci -m "可以加备注说明" # svn commit
svn add
svn sw # svn switch
svn info
svn merge # 合并操作容易产生冲突，需要谨慎处理
svn relocate from-url to-url # 切换url
svn revert # 可把本地代码变动恢复，可恢复到指定版本，提交时需谨慎
```
4. 可选参数
```
# 全局参数
--username test # 可以指定账号
--password testpassword # 对应的密码

# up
-r version # 可指定更新至特定版本

# sw
-r version # 可指定切换至特定版本
```
5. 分支问题
- trunk分支作为当前活跃分支
- 若遇到比较大的改动，不想干扰trunk分支以及其他开发者，可单独分一个分支
- 需及时把trunk分支的变更合并到各分支，分支一般等完成任务再合并到trunk
- 上线大版本后一般需要从trunk分一个tag分支进行标记为当前最终版

##### 4、服务端地址如何配置


##### 5、服务端的文件数据存在哪里
