#!/bin/bash

echo "Pushing DEV branch to DEV"

ssh ec2-user@ec2-107-22-112-19.compute-1.amazonaws.com "cd /PT/production/Project_Hermes;sudo git reset --hard HEAD;sudo git checkout dev;sudo git pull origin dev;echo 'DONE';"

