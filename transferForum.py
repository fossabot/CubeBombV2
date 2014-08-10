#!/usr/bin/python
import MySQLdb
import time
import datetime

# Function to create new database connection for requested database
def get_db_connection(db_name):
    return MySQLdb.connect("localhost", "cbdbuser", "Typ5mmRx7PUKwUwd", db_name)

db = get_db_connection("cubebomb2")
db.autocommit(1)

cur = db.cursor()
    
def get_id(username):
    cur.execute("SELECT COUNT(`id`) FROM `cubebomb2`.`private_users` WHERE LOWER(`username`) =LOWER('" + db.escape_string(username) + "')")
    if cur.fetchall()[0][0] > 0:
        cur.execute("SELECT `id` FROM `cubebomb2`.`private_users` WHERE LOWER(`username`) =LOWER('" + db.escape_string(username) + "') LIMIT 0, 1")
        return cur.fetchall()[0][0]
    else:
        return 0

def insert_thread(title, timestamp, userid, forumid, deleted, locked, sticky):
    cur.execute("INSERT INTO `cubebomb2`.`public_forums_threads` (`userid`, `timestamp`, `title`, `forumid`, `deleted`, `views`, `canReply`, `sticky`) VALUES ('" + db.escape_string(str(userid)) + "', FROM_UNIXTIME(" + db.escape_string(str(timestamp)) + "), '" + db.escape_string(str(title)) + "', '" + db.escape_string(str(forumid)) + "', '" + db.escape_string(str(deleted)) + "', '0', '" + db.escape_string(str(locked)) + "', '" + db.escape_string(str(sticky)) + "');")
    
    return cur.lastrowid
    
def insert_post(threadid, userid, content, timestamp, deleted):
    cur.execute("INSERT INTO `public_forums_posts` (`postid`, `userid`, `timestamp`, `content`, `deleted`) VALUES ('" + db.escape_string(str(threadid)) + "', '" + db.escape_string(str(userid)) + "', FROM_UNIXTIME(" + db.escape_string(str(timestamp)) + "), '" + db.escape_string(str(content)) + "', '" + db.escape_string(str(deleted)) + "');")
    
def insert_edit(postid, userid, content, timestamp, deleted):
    cur.execute("INSERT INTO `public_forums_posts_edits` (`userid`, `postid`, `timestamp`, `content`, `deleted`, `editedByUserId`) VALUES ('" + db.escape_string(str(userid)) + "', '" + db.escape_string(str(postid)) + "', FROM_UNIXTIME('" + db.escape_string(str(timestamp)) + "'), '" + db.escape_string(str(content)) + "', '" + db.escape_string(str(deleted)) + "', '" + db.escape_string(str(userid)) + "');")
    
# Transfer topics
print("Transferring topics");
cur.execute("SELECT * FROM `cbdata`.`forum-topics` ORDER BY `id` ASC");

for topic in cur.fetchall():
    originalId = topic[0]
    print(originalId)
    
    newId = insert_thread(topic[5], topic[2], topic[4], topic[12], topic[7], (1, 0)[topic[6] == "false"], topic[8])
    
    cur.execute("SELECT * FROM `cbdata`.`forum-posts` WHERE `postid` = '" + db.escape_string(str(originalId)) + "'")
    
    for post in cur.fetchall():
        insert_post(newId, post[2], post[4], post[7], post[8]);
        print("    " + str(post[0]) + " -> " + str(originalId) + " - > " + str(newId))
        
        # Transfer edits
        cur.execute("SELECT * FROM `cbdata`.`forum-posts-updates` WHERE `postid` = '" + db.escape_string(str(post[0])) + "'")
        for edit in cur.fetchall():
            print("      +Edit");
            insert_edit(newId, edit[2], edit[3], edit[4], edit[5])

# finish up
if db:
    db.close()