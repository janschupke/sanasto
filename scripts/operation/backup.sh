#!/bin/bash

# Database backup script. Dumps the application database into a file.

export PGPASSWORD="placeholder"
PGUSER="placeholder"
DBNAME="placeholder"
BACKUP_FOLDER="../../files/backup"
FILENAME="`date +"%Y-%m-%d_%H-%M-%S"`.sql"

pg_dump -U $PGUSER -Fp $DBNAME > $BACKUP_FOLDER/$FILENAME

# The most recent backup file with fixed filename
# for the restore script to read.
rm $BACKUP_FOLDER/last.sql 2> /dev/null
cp $BACKUP_FOLDER/$FILENAME $BACKUP_FOLDER/last.sql
