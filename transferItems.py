#!/usr/bin/python
import MySQLdb
import os.path
import os
import shutil
import hashlib
import time
import datetime

# Function to create new database connection for requested database
def get_db_connection(db_name):
    return MySQLdb.connect("localhost", "cbdbuser", "Typ5mmRx7PUKwUwd", db_name)

db = get_db_connection("cubebomb2")
db.autocommit(1)

cur = db.cursor()

# Stores item in database 
def insert_item(userid, official, deleted, originalid, wasuseritem, timestamp, image_uri, name, description, cost, forsale):
    # Store the new image or catch error
    image = store_image(image_uri, userid, 1, 0, str(timestamp))
    
    if image != -1:
        
        # Fix timestamp error
        if timestamp >= 2147483647:
            timestamp = 1401582397
        
        # Insert item record
        cur.execute("INSERT INTO `cubebomb2`.`copy_public_items` (`userid`, `timestamp`, `deleted`, `official`, `originalid`, `wasuseritem`) VALUES ('" + str(userid) + "', FROM_UNIXTIME(" + str(timestamp) + "), '" + str(deleted) + "', '" + str(official) + "', '" + str(originalid) + "', '" + str(wasuseritem) + "');")        
        # Get inserted row id
        iid = cur.lastrowid
        
        # Insert item details
        cur.execute("INSERT INTO `cubebomb2`.`copy_public_items_details` (`itemid`, `name`, `description`, `cost`, `forsale`, `timestamp`, `image`) VALUES ('" + str(iid) + "', '" + name + "', '" + description + "', '" + str(cost) + "', '" + str(forsale) + "', FROM_UNIXTIME(" + str(timestamp) + "), '" + str(image) +"'); ")
                
        return 1
    else:
        return 0

# Stores image in database and generates preview
# Returns -1 on error
def store_image(original_uri, userid, accepted, deleted, timestamp):
    if os.path.isfile(original_uri):
        
        # Convert the value to a friendly database format
        if accepted:
            denied = 0
        else:
            denied = 1
        
        # Check file extension and assign appropriate values
        if original_uri.lower().endswith(".png"):
            filetype = 1
            ext = ".png"
        elif original_uri.lower().endswith(".jpg") or original_uri.lower().endswith(".jpeg"):
            filetype = 2
            ext = ".jpg"
        else:
            # Error, filetype not supported
            return -1
        
        # Insert initial row into database
        cur.execute("INSERT INTO `cubebomb2`.`copy_private_images` (`userid`, `location`, `checksum`, `filetype`, `timestamp`, `denied`, `deleted`)VALUES ('" + str(userid) + "', '00000000000000000000000000000000', '00000000000000000000000000000000', '" + str(filetype) + "', FROM_UNIXTIME(" + str(timestamp) + "), '" + str(denied) + "', '" + str(deleted) + "');")
                
        # Get inserted row id to generate filename
        iid = cur.lastrowid
        
        # Generate new filename
        # Filename is a hash of the id of the new row in parantehesis (as a salt)
        # For example: id 253 => md5("(253)")
        m = hashlib.md5()
        m.update("(" + str(iid) + ")")
                
        filename = m.hexdigest()
        
        # Rename the file (move it) to the new location
        shutil.copy(original_uri, "/var/www/html/data/items/" + filename + ext)
        
        # Compress image file
        # os.system("optipng -quiet " + "/var/www/html/data/items/" + filename + ext);
        
        # Generate checksum of file
        m = hashlib.md5()
        m.update(open("/var/www/html/data/items/" + filename + ext).read())
        
        checksum = m.hexdigest()
        
        # Finish the query and update record
        cur.execute("UPDATE `copy_private_images` SET `location` = '" + filename + "', `checksum` = '" + checksum + "' WHERE `id` =" + str(iid) + ";")
        
        # Generate preview
        os.system("convert /var/www/html/images/avatars/blank.png /var/www/html/data/items/" + filename + ext + "[512x512] -background none -flatten /var/www/html/data/items/previews/full/" + str(iid) + ext)
        os.system("convert /var/www/html/images/avatars/blank.png[200x200] /var/www/html/data/items/" + filename + ext + "[200x200] -background none -flatten /var/www/html/data/items/previews/200/" + str(iid) + ext)
        
        # Compress preview files
        #os.system("optipng -quiet " + "/var/www/html/data/items/previews/full/" + str(iid) + ext);
        #os.system("optipng -quiet " + "/var/www/html/data/items/previews/200/" + str(iid) + ext);
        
        # Return the id of the inserted image
        return iid
    else:
        return -1
    
def get_id(username):
    cur.execute("SELECT COUNT(`id`) FROM `cubebomb2`.`private_users` WHERE LOWER(`username`) =LOWER('" + db.escape_string(username) + "')")
    if cur.fetchall()[0][0] > 0:
        cur.execute("SELECT `id` FROM `cubebomb2`.`private_users` WHERE LOWER(`username`) =LOWER('" + db.escape_string(username) + "') LIMIT 0, 1")
        return cur.fetchall()[0][0]
    else:
        return 0
    
def get_new_itemid(oldid, useritem):
    cur.execute("SELECT COUNT(`id`) FROM `copy_public_items` WHERE `originalid` ='" + str(oldid) + "' AND `wasuseritem` = '" + str(useritem) + "'")
    if cur.fetchall()[0][0] > 0:
        cur.execute("SELECT `id` FROM `copy_public_items` WHERE `originalid` ='" + str(oldid) + "' AND `wasuseritem` = '" + str(useritem) + "'")
        return cur.fetchall()[0][0]
    else:
        return -1

print("Beginning to transfer items")
print("Official catalog:")

cur.execute("SELECT * FROM `cbdata`.`items` WHERE `gif` = '0'")

for row in cur.fetchall():
    print("Official " + str(row[0]) + " " + str(row[1]) + "/var/www/secure/sources/official/HatID"+str(row[0])+".png")
    print insert_item(get_id(row[5]), 1, row[11], row[0], 0, time.mktime(datetime.datetime.strptime(row[6], "%m/%d/%Y").timetuple()), "/var/www/secure/sources/official/HatID"+str(row[0])+".png", db.escape_string(row[1]), db.escape_string(row[2]), str(row[3]), str(0))
    
print("User Catalog:")
    
cur.execute("SELECT * FROM `cbdata`.`user-items`")

for row in cur.fetchall():
    m = hashlib.md5()
    m.update(str(row[0]))
    
    print("User " + str(row[0]) + " /var/www/secure/sources/user/" + m.hexdigest() + ".png")
    print insert_item(str(row[4]), str(0), str(row[7]), str(row[0]), "1", str(row[5]), "/var/www/secure/sources/user/" + m.hexdigest() + ".png", db.escape_string(row[1]), db.escape_string(row[2]), str(row[8]), str(row[10]))

print("Transferring purchases")
print("Official purchases:");

cur.execute("SELECT * FROM `cbdata`.`purchases_official` ORDER BY `itemid`")

for row in cur.fetchall():
    nid = get_new_itemid(str(row[1]), 1)
    
    print("User " + str(row[1]) + " as " + str(nid) + " for " + str(row[2]))
    
    if nid == -1:
        print("Item doesn't exist. Failed.")
    else:
        cur.execute("SELECT COUNT(`id`) FROM `copy_private_purchases` WHERE `userid` ='" + str(row[2]) + "' AND `itemid` ='" + str(nid) + "' AND `deleted` =0")
        if cur.fetchall()[0][0] == 0:
            cur.execute("INSERT INTO `copy_private_purchases` (`userid`, `itemid`, `timestamp`, `deleted`) VALUES ('" + str(row[2]) + "', '" + str(nid) + "', FROM_UNIXTIME('" + str(row[3]) + "'), '" + str(row[4]) + "');")
        else:
            print("User " + str(row[1]) + " has item " + str(nid) + " already.")
        

print("Transferring purchases")
print("User purchases:");

cur.execute("SELECT * FROM `cbdata`.`purchases_usercat` ORDER BY `itemid`")

for row in cur.fetchall():
    nid = get_new_itemid(str(row[1]), 1)
    
    print("User " + str(row[1]) + " as " + str(nid) + " for " + str(row[2]))
    
    if nid == -1:
        print("Item doesn't exist. Failed.")
    else:
        cur.execute("SELECT COUNT(`id`) FROM `copy_private_purchases` WHERE `userid` ='" + str(row[2]) + "' AND `itemid` ='" + str(nid) + "' AND `deleted` =0")
        if cur.fetchall()[0][0] == 0:
            cur.execute("INSERT INTO `copy_private_purchases` (`userid`, `itemid`, `timestamp`, `deleted`) VALUES ('" + str(row[2]) + "', '" + str(nid) + "', FROM_UNIXTIME('" + str(row[3]) + "'), '" + str(row[4]) + "');")
        else:
            print("User " + str(row[1]) + " has item " + str(nid) + " already.")


# finish up
if db:
    db.close()