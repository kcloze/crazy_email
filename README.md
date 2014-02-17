# 简单邮件发送控制系统

## [特点]

1.小巧灵活，不用第三方php框架

2.基于SMTP，简单高效，配置灵活

## [场景]

电商业务应该经常要给客户发送邮件，邮件可能会有优先级

每天发送的邮件不能太多，数量要有控制，要记录发送状态


## [依赖组件]

1.Medoo 数据库orm框架，文档地址：https://github.com/catfan/Medoo

2.邮件发送主类库 PHPMailer，文档地址：https://github.com/PHPMailer/PHPMailer

## [文件结构说明]

```
crazy_email/
├── class/
│   类库
│   
├── data/
│   数据库sql等相关资源目录
│   
└── lib/
    第三方类库
index.php 入口文件
config.php  相关配置

```


## [使用方法]

一.导入data/send_email.sql表结构

二.配置config.php相关信息
   把带星号的配置项改成自己服务器相关配置(数据库和smtp邮件服务器)

三.执行add.php,增加测试数据

四.执行index.php，当然如果是正式环境，应该把index.php增加到定时任务




##[辅助信息]

一.增加定时任务

1.新建sh文件，send_email.sh,增加可执行权限，内如如下：

```
\#!/bin/bash

/opt/php54/bin/php /data/vhost/test/crazy/index.php

```

2.把send_email.sh，加入crontab 定时任务




