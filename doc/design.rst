==============
page relations
==============
| db_connect.php // *for all page need db*
| base.php 
|  main page
|  userinfo
|  delete user // delete_user.php

| index.php    // *首頁*
|  login => login.php (select)
|  signup => signup.php (insert)
| main.php     // *FaceNote 主頁面*
|  list article
|  list friend
|  post article => post_article.php
|  like article => like.php
|  delete like => like.php
|  delete article => delete_article.php
| userinfo.php 
|  list userinfo 
|  list friend
|  add friend => add_friend.php
|  delete friend => delete_friend.php
| logout.php   // *unset session["uid"]*

=====
pages
=====
Direct pages
------------
| tem_header.php (base.css)
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
| /model/delete.php

template
--------
| /template/tem_header.php
| /template/template.php
