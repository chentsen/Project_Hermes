#!/bin/bash

echo "Pushing Production branch to PRODUCTION"

ssh ec2-user@ec2-184-73-13-197.compute-1.amazonaws.com "cd /PT/production/Project_Hermes;sudo git reset --hard HEAD;sudo git checkout production;sudo git pull origin production;echo 'DONE'"

