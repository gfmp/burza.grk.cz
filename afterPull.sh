#!/usr/bin/env bash

mkdir ./temp
mkdir ./log

rm -rf ./temp/*
rm -rf ./log/*

chmod 0777 ./log/
chmod 0777 ./temp/

composer update