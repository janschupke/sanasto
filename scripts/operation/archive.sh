#!/bin/bash

# Backup archivation script. Takes all backup files from the backup folder,
# creates an archive containing them in the archive folder,
# and removes the original backup files, if the archivation is successful.

FILEFOLDER="../../files"
FILENAME="`date +"%Y-%m-%d_%H-%M-%S"`.tar.gz"

cd $FILEFOLDER
tar czf archive/$FILENAME backup/* && rm -f backup/2*
