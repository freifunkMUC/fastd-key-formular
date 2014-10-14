#!/bin/bash
cd keys
../git-pull.sh
git add .
git commit -a -m "new key"
../git-push.sh
