#!/bin/bash

cd ../../app

find . \
    -type f -exec wc -l {} \; \
    | awk '
        BEGIN {
            files=0;
        }
        {
            sum+=$1;
            files++;
        }
        END {
            print "Files:\t" files;
            print "Lines:\t" sum;
        }'
