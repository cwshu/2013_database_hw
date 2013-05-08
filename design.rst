pages
=====
db_connect.php // for all page need db

index.php    // 首頁
- login => login.php (select)
- signup => signup.php (insert)

main.php     // FN 主頁面
- list article
- list friend
- post article =>
- like article 

userinfo.php 
- list userinfo
- list friend
- add friend

logout.php   // close session

tables
======

users
- uid, password, name, email, birthday, sex
friends
- uid, friend_id, relationship
articles
- uid, postid, content, time
like
- postid, uid

