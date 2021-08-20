### 0、参考文档
1. [Git教程（完整）](https://blog.csdn.net/weixin_42152081/article/details/80558282)
2. [Git版本恢复命令reset和revert](https://blog.csdn.net/xybelieve1990/article/details/62885292)
3. [github官方指引](https://guides.github.com/activities/hello-world/)
4. [使用git克隆指定分支的代码](https://blog.csdn.net/dubo_csdn/article/details/81743495)
5. [一个成功的Git分支模型](https://www.jianshu.com/p/b357df6794e3)
### 1、创建项目
> [Git教程（完整）](https://blog.csdn.net/weixin_42152081/article/details/80558282)
##### 0. 安装Git
参照上面的教程即可，这部分比较简单
```
sudo apt -get install git

// 设置用户名，邮箱
git config --global user.name=username
git config --global user.email=email
```

##### 1. 创建一个空目录，作为项目的根目录
```
mkdir learngit
```

##### 2. 初始化，设置为一个git仓库
```
cd learngit
git init
```

##### 3. 创建完毕

### 2、客户端使用
0. 与SVN的差异
> git以本地作为一个仓库，修改提交都在本地生效，只有最后的推送到远程才是代码上交合并；SVN的每次修改提交都是最终的代码上交合并

> git本地仓库存在工作区、暂存区、仓库三个概念，所有需要提交的必须先放入暂存区，所有的提交都仅仅是把暂存区放入仓库，工作区依然可以存在差异；SVN没有暂存区的概念，提交则提交当前工作区

##### 1. 添加文件
```
git add filename // 指定文件
git add . // 当前目录所有
```
1. 无法添加空文件夹
> git默认不支持空文件夹，若想提交需要在文件夹里添加一个文件，比如`.gitkeep`、`.gitconfig`
##### 2. 提交到仓库
```
git commit -m "备注信息" // 把stage里的内容提交到仓库
// 把modified、deleted放入stage并提交到仓库，Untracked files则不生效，慎用
git commit -a -m "备注信息" 
```
- 只有放入了stage缓存区的内容才会被提交
- 缓存区需要执行```git add```才会被放入
- ```git commit -a```会把变动的文件(新文件不生效)放入stage并提交到仓库，慎用
##### 3. 查看状态，差异
```
git status // 查看状态
# nothing to commit, working tree clean 当前没有需要提交的修改，而且，工作目录是干净的。
# Changes to be commited 将要被提交的文件
# Changes not staged for commit 没有文件将要被提交

git diff // 查看当前具体变动内容
```
##### 4. 查看日志
```
git log --pretty=oneline
```
##### 5. 回退版本，撤销修改
1. 本地回退，未进入stage
```
git checkout --filename // 直接checkout文件即可
git checkout . // 本地所有回退

// 或使用restore
git restore filename // 把工作区的某个文件撤销
git restore . // 放弃所有修改
```
2. 已提交到stage
```
git restore --staged filename // 把暂存区的某个文件撤销

// 或者使用reset
git rest HEAD filename // 指定文件撤回
git rest HEAD . // 放弃所有缓存
```
3. 已commit
```
git reset --hard HEAD^ // 回退到上一版本 HEAD^^(上两个版本)
git reset --hard 0455g // 指定版本，一般取commit id的前5位
```
4. 已提交到remote，需要回退版本
```
git revert commit-id // 回滚到某个提交
git commit -a -m "重新提交回滚后的内容即可回到之前版本"
git push origin master
```
5. reset与revert的区别
> 第一:上面我们说的如果你已经push到线上代码库, reset 删除指定commit以后,你git push可能导致一大堆冲突.但是revert 并不会.

> 第二:如果在日后现有分支和历史分支需要合并的时候,reset 恢复部分的代码依然会出现在历史分支里.但是revert 方向提交的commit 并不会出现在历史分支里.

> 第三:reset 是在正常的commit历史中,删除了指定的commit,这时 HEAD 是向后移动了,而 revert 是在正常的commit历史中再commit一次,只不过是反向提交,他的 HEAD 是一直向前的.

##### 6. 拉取
```
git fetch // 获取
git merge // 合并

// 也可合并使用，包含了fetch和merge
git pull
```
##### 7. 分支
> [使用git克隆指定分支的代码](https://blog.csdn.net/dubo_csdn/article/details/81743495)
```
git branch // 查看分支
git branch branchName // 创建分支
git checkout branchName // 切换分支
git checkout -b branchName // 创建并切换分支
git branch -d branchName // 删除分支

// 其他一些分享
查看各个分支当前所指的对象   git log --oneline --decorate
项目分叉历史  git log --oneline --decorate --graph --all
分支创建  git branch testing
分支切换  git checkout testing
创建加切换 git checkout -b testing
分支都会向前移动一步  git commit -m "A"  (ABCD....)
创建分支 git checkout dev
代表切换分支   git checkout -b  dev 
查看当前分支 git branch
提交分支 git add readme.txt 
创建分支下的分支  git commit -m "d"      (git commit -m “branch test”)
把分支移到主分支上 git checkout master
合并分支   git merge dev
删除分支  git branch -d dev
```
##### 8. 合并
> [3.2 Git 分支 - 分支的新建与合并](https://git-scm.com/book/zh/v2/Git-%E5%88%86%E6%94%AF-%E5%88%86%E6%94%AF%E7%9A%84%E6%96%B0%E5%BB%BA%E4%B8%8E%E5%90%88%E5%B9%B6)
```
git checkout -b branchName fromBranchName // 创建并切换到新分支，比如修复bug
git commit -a -m "修复完bug，提交"
git checkout master // 切回master
git merge branchName // 把修复完bug的分支合并到master分支
git branche -d branchName // 修复完了，删除之
```
> 所有这些操作都需要在同一工作区操作


### 3、github
##### 1. SSH
> github拉代码需要ssh验证

> git是分布式的代码管理工具，远程的代码管理是基于ssh的，所以要使用远程的git则需要ssh的配置。
1. 生成秘钥
```
ssh-keygen -t rsa -C "github邮箱"
```
> 按3个回车，密码为空这里一般不使用密钥。
> 最后得到了两个文件：`id_rsa`和`id_rsa.pub`
2. 在github上配置
>github上的路径：Account>settings>SSH and GPG keys>添加sshkey。
>在github上添加ssh密钥，这里需要添加的是`id_rsa.pub`里面的公钥。这里需要注意编码问题，最好使用编辑器打开，直接拷贝到github即可
3. 测试是否成功
```
ssh -T git@github.com
```
> 回复yes，若出现了你github的昵称则设置成功

##### 2. 上传到github
1. 在项目里设置remote地址
```
// origin为github默认使用的名字
git remote add origin git@github.com:lpp864019150/learngit.git
```
2. 上传
```
// origin为github默认使用的名字
git push -u origin master
// 如果本地分支名与远程分支名相同，则可以省略冒号后面的远程分支名
git push <远程主机名> <本地分支名>:<远程分支名>
```
##### 3. clone
```
// 可以设置本地目录名，默认为远程同名
// 可以使用-b指定clone的分支，默认为master
git clone -b branches git@github.com:lpp864019150/learngit.git dirname 
```
##### 4. create pull request 
> 直接参照官方指引操作即可 [github官方指引](https://guides.github.com/activities/hello-world/)

### 4、GIT分支管理
##### 0. [一个成功的Git分支模型](https://www.jianshu.com/p/b357df6794e3)
##### 1. master主分支
> 主分支，一般作为稳定版，默认版本，与线上保持一致，所以分支需要发布最终都要合并到`master`
##### 2. develop主分支
> 另一个主分支，不直接参与变更，来源于下面几个辅助分支，当分支里面合并的代码达到某个稳定点，可以进行新版本发布，合并到`master`并打tag标签
##### 3. feature辅助分支
> 需求分支，一些新特性，新需求，属于实验性或者其他原因，并不一定会合并到`master`
##### 4. release辅助分支
> 版本开发分支，一般作为一个独立版本来进行开发，可以以一个固定周期来进行发版，从`develop`来，合并到`develop`进行测试，最后合并到`master`分支并打标签，以`release-`作为前缀，用完即删

> ps. 与我们目前SNV的dev分支类似，作为主开发分支，当前开发版本
##### 5. hotfix辅助分支
> 修复分支，一般作为紧急bug修复，从`master`分支来，合并到`develop`进行测试，最后合并到master分支并打标签，以`hotfix-`作为前缀，用完即删