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


# Stores image in database and generates preview
# Returns -1 on error
def store_image(original_uri, userid, accepted, deleted):
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
        cur.execute("INSERT INTO `cubebomb2`.`copy_private_images` (`userid`, `location`, `checksum`, `filetype`, `timestamp`, `denied`, `deleted`)VALUES ('" + str(userid) + "', '00000000000000000000000000000000', '00000000000000000000000000000000', '" + str(filetype) + "', now(), '" + str(denied) + "', '" + str(deleted) + "');")
                
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
        #os.system("convert /var/www/html/images/avatars/blank.png /var/www/html/data/items/" + filename + ext + "[512x512] -background none -flatten /var/www/html/data/items/previews/full/" + str(iid) + ext)
        #os.system("convert /var/www/html/images/avatars/blank.png[200x200] /var/www/html/data/items/" + filename + ext + "[200x200] -background none -flatten /var/www/html/data/items/previews/200/" + str(iid) + ext)
        
        # Compress preview files
        #os.system("optipng -quiet " + "/var/www/html/data/items/previews/full/" + str(iid) + ext);
        #os.system("optipng -quiet " + "/var/www/html/data/items/previews/200/" + str(iid) + ext);
        
        # Return the id of the inserted image
        return iid
    else:
        return -1

# Cycle through all images
for i in range (1, 10774):
    m = hashlib.md5()
    m.update("(" + str(i) + ")")

    filename = m.hexdigest()
    ext = ".png"

    if os.path.isfile("/var/www/html/data/items/" + filename + ext):
        print("Processing image "+str(i)+"/10743 ("+str('%.1f' % ((i/10773.0)*100.0))+")% /var/www/html/data/items/" + filename + ext);
        
        # Generate preview
        os.system("convert /var/www/html/images/avatars/blank.png /var/www/html/data/items/" + filename + ext + "[512x512] -background none -flatten /var/www/html/data/items/previews/full/" + str(i) + ext)
        os.system("convert /var/www/html/images/avatars/blank.png[200x200] /var/www/html/data/items/" + filename + ext + "[200x200] -background none -flatten /var/www/html/data/items/previews/200/" + str(i) + ext)
        
        if not os.path.isfile("/var/www/html/data/items/previews/200/" + str(i) + ext):
            print("Bad image file. Converted previews don't exist. Deleting image and item")
            
            # Delete image and item
            cur.execute("UPDATE `copy_private_images` SET `deleted` = '1' WHERE `id` = '"+str(i)+"';")
            cur.execute("SELECT `itemid` FROM `copy_public_items_details` WHERE `image` ='"+str(i)+"'")
            cur.execute("UPDATE `copy_public_items` SET `deleted` = '1' WHERE `id` = '"+str(cur.fetchall()[0][0])+"';")
            
            continue
            
        # Compress preview files
        #os.system("optipng -quiet " + "/var/www/html/data/items/previews/full/" + str(i) + ext);
        #os.system("optipng -quiet " + "/var/www/html/data/items/previews/200/" + str(i) + ext);
            
    else:
        # File doesn't exist, check image record
        cur.execute("SELECT COUNT(`id`) FROM `copy_private_images` WHERE `id` ='"+str(i)+"'")
        if cur.fetchall()[0][0] > 0:
            # Image record exists, file does not
            print("Image record for "+str(i)+" exists, file does not. Deleting image and item.")
            
            # Delete image and item
            cur.execute("UPDATE `copy_private_images` SET `deleted` = '1' WHERE `id` = '"+str(i)+"';")
            cur.execute("SELECT `itemid` FROM `copy_public_items_details` WHERE `image` ='"+str(i)+"'")
            cur.execute("UPDATE `copy_public_items` SET `deleted` = '1' WHERE `id` = '"+str(cur.fetchall()[0][0])+"';")
        else:
            # There's nothing that can be done
            continue
        

# finish up
if db:
    db.close()