#!/bin/bash

# https://github.com/mishoo/UglifyJS

JSPATH=public/js

shrinkit () {
  echo $1
  uglifyjs  --compress --mangle --warn  $JSPATH/$1.js > $JSPATH/$1.min.js
}

#--keep-fargs --keep-fnames

#shrinkit "history"
#shrinkit "inventory"
#shrinkit "facilityusage"
#hrinkit "exception"
shrinkit "dos"
shrinkit "dash"
#shrinkit "chemical"
#shrinkit "elemco"
#shrinkit "active"
#shrinkit "barcode"


