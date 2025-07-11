#!/bin/bash

cd ../../app/resources/

rm css/structure.css 2> /dev/null
rm css/theme.css 2> /dev/null
mkdir css 2> /dev/null

lessc less/structure.less > css/structure.css
lessc less/theme.less > css/theme.css
