#!/bin/bash
echo "Pushing "$1" branch to personal test environment"
ssh ec2-user@ec2-107-22-112-19.compute-1.amazonaws.com "cd /PT_"$1"/production/Project_Hermes;sudo git reset --hard HEAD;sudo git checkout dev_"$1";sudo git pull origin dev_"$1";echo 'DONE';"

