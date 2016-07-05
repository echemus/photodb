#!/bin/bash
# insert creation date
echo UPDATE photos set create_date '`exiftool -createdate $1`' WHERE filename = '$1';
#
