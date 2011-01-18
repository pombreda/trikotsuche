#!/bin/sh
CWD=`pwd`
mkdir /tmp/tr
cp -R * /tmp/tr/
rm -rf /tmp/tr/scripts /tmp/tr/test /tmp/tr/cache/*
cd /tmp/tr/
tar czf tr.tgz *
mv tr.tgz $CWD/
#rm -rf /tmp/tr