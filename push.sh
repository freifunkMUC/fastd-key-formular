#!/bin/bash
cd keys
git add .
git commit -a -m "new key"
../git-push.sh
