======
tables
======
| users
|  uid, password, name, email, birthday, sex, icon
| friends
|  uid, friend_id, relationship
| articles
|  uid, postid, content, time
| likes
|  postid, uid
| responses
|  postid, r_postid, uid, content, time

users-icon-path/name:
./upload/[uid]_icon.xxx

usage
-----
| user
|  search one user ?method=search&uid=$uid
|  search one user name ?method=search&uid=$uid&attr=name
|  insert one user ?method=insert&uid=$uid& other info
|  update one user (x) ?method=update
|  delete one user (4)
| friends
|  search one's friend
|  insert one's friend
|  update one's friend relationship (x)
|  delete one's friend (4)
| articles
|  search many people's
|  ...
| likes
|  delete one's likes for one article (4)
