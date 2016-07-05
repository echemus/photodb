#!/bin/bash
# create photo names
echo ,\(\'$1\',\'`md5sum -b "$1"|cut -f 1 -d' '`\'\)
