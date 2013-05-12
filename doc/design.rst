pages
=====
db_connect.php // for all page need db
base.php // 

index.php    // 首頁
- login => login.php (select)
- signup => signup.php (insert)

main.php     // FN 主頁面
- list article
- list friend
- post article => post_article.php
- like article => like.php

userinfo.php 
- list userinfo 
- list friend
- add friend => add_friend.php

logout.php   // close session

tables
======

users
- uid, password, name, email, birthday, sex
friends
- uid, friend_id, relationship
articles
- uid, postid, content, time
likes
- postid, uid

pages
=====
base.php (base.css)
index.php (index.css)
main.php (main.css)
userinfo.php (userinfo.css)

db_connect.php

login.php
logout.php
signup.php
post_article.php
add_friend.php
like.php

====
MVC 
