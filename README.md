# php
梳理PHP的基础知识

基础知识
========
1.include、include_once、require、require_once区别
---------
include在引入不存在文件时会产生一个警告且脚本还会继续执行，而require则会导致一个致命性的错误且脚本停止运行。  
include_once和require_once在加载文件时会进行一次的查询，确认是否存在，然后在进行加载。

2.Cookie和Session的工作机制
----------
cookie机制采用客户端保持状态  
session机制采用服务端保持状态，采用服务端保持状态的方案需要在客户端也要保存一个标识，所以session机制可能需要借助cookie机制来达到保存标识的目的，但实际上还有其他选择。  
cookie是通过扩展http协议来实现的，服务器通过在HTTP响应头中添加一行特殊的指示(Set-Cookie)，以提示浏览器按照指示生成相应的cookie，纯粹的脚本js或者vbscript也可以生成cookie。cookie的主要内容包括：名字，值，过期时间，路径和域。  
session是一种服务端的机制，当程序需要为某个客户端的请求创建一个session时，服务器会先检查这个客户端请求是否包含了一个session标识，称为session id，如果包含session id则说明以前已经为此客户端创建过session，服务器按照session id把这个session检索出来，如果检索不到，可能会新建一个，如果客户端请求不包含session id，则为此客户端创建一个session并且生成一个于此关联的session id，session id的值应该是一个不会重复，又不容易被找到规律以仿造的字符串，这个session id在本次响应中返回给客户端保存。保存session id的方式可以采用cookie，这样在交互过程中浏览器可以自动按照规则把这个标识发给服务器。由于cookie可以被人为禁止，必须有其他机制以便在cookie禁止时，仍然能够把session id传递给服务器，经常被使用的一种技术叫做URL重写(将session_id放在url的后面)，还有一种是表单隐藏字段。  
3.session共享
---------------
由于多台服务器进行负载均衡的时候，多台服务器上拥有相同的代码，不能保证每次访问都是同一台服务器，所以就需要session共享。
>解决方案
>>1.将原来存储在服务端的session数据存储到cookie中去（优势：服务器压力小，不会存在读不到的情况 劣势：cookie存在大小限制，高访问的情况下，每个浏览器都需要给服务器发送数据，占了带宽，成本增加，安全问题）  
>>2.分发请求，将相同的用户id根据算法分发到同一台服务器上(如果宕机那就访问不了了，需要做其他的宕机设计)  
>>3.做个中间层，专门用来存储所有访问涉及的session，服务端统一从这里读取session数据（方案：1.访问量小可以使用mysql进行存储，存在弊端就是每次刷新页面或者其他操作都需要去数据库，session数据定时删除也需要处理 2.NFS文件共享，通过共享服务器上的文件 3.放到NOSQL中即redis memcache内存数据库中（推荐））  
4.get和post
--------------
GET在浏览器回退时是无害的，POST会再次提交请求。
GET传送的数据量比较小，不能大于2KB，GET安全性非常低，POST安全性比较高，POST大小可以由服务器进行设置。  
5.PHP的闭包
--------------
闭包函数  

	$func = function($param){
	    echo $paraml
	};
	$func('something');   

实现闭包  
 
	//例一
	//在函数里定义一个匿名函数，并且调用它
	function printStr() {
    	$func = function( $str ) {
        	echo $str;
    	};
    	$func('some string');
	}
	printStr();

	//例二
	//在函数中把匿名函数返回，并且调用它
	function getPrintStrFunc() {
    	$func = function( $str ) {
        	echo $str;
    	};
    	return $func;
	}
	$printStrFunc = getPrintStrFunc();
	$printStrFunc('some string');

	//例三
	//把匿名函数当做参数传递，并且调用它
	function callFunc($func) {
    	$func('some string');
	}
	$printStrFunc = function($str) {
    	echo $str;
	};
	callFunc($printStrFunc);
	//也可以直接将匿名函数进行传递。如果你了解js，这种写法可能会很熟悉
	callFunc(function($str) {
    		echo $str;
	});

连接闭包和外界变量的关键字：USE  

	function getMoney() {
    	$rmb = 1;
    	$dollar = 6;
    	$func = function() use ($rmb) {
        	echo $rmb;
        	echo $dollar;
    	};
    	$func();
	}
	getMoney();
	//输出：
	//1
	//报错，找不到dorllar变量  
原来use所引用的也只不过是变量的一个副本而已。但是我想要完全引用变量，而不是复制。 要达到这种效果，其实在变量前加一个 & 符号就可以了：  

	function getMoney() {
	    $rmb = 1;
	    $func = function() use (&$rmb) {
	        echo $rmb;
	        //把$rmb的值加1
	        $rmb++;
	    };
	    $func();
	    echo $rmb;
	}
	getMoney();
	//输出：
	//1
	//2  
6.php.ini详细解释  
-----------------------------
见文件夹中翻译