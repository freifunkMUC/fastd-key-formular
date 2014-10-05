#!/bin/bash
cd keys
git pull
git add .
git commit -a -m "new key"
../git-push.sh
