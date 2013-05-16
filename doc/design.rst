==============
page relations
==============
| db_connect.php // *for all page need db*
| base.php // 

| index.php    // *首頁*
|  login => login.php (select)
|  signup => signup.php (insert)
| main.php     // *FaceNote 主頁面*
|  list article
|  list friend
|  post article => post_article.php
|  like article => like.php
| userinfo.php 
|  list userinfo 
|  list friend
|  add friend => add_friend.php
| logout.php   // *unset session["uid"]*

=====
pages
=====
Direct pages
------------
| base.php (base.css)
| index.php (index.css)
| main.php (main.css)
| userinfo.php (userinfo.css)

Functions
---------
| db_connect.php

Indirect pages
--------------
| login.php
| logout.php
| signup.php
| post_article.php
| add_friend.php
| like.php

===
MVC
===
model
-----
| /model/search.php
| /model/insert.php

