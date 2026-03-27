#!/bin/bash

#Frame rate
Rate=$1

#Thumb base name
ThumbBaseName=$2

#Filename with full path
FileName=$3

OutputDirectory=/examples-php/11-Players/Thumbs/${ThumbBaseName}/

mkdir -p ${OutputDirectory}

echo "Request rate: $1 (${Rate})"
echo "Thumb base name: ${ThumbBaseName}"
echo "Input file: ${FileName}"
echo "Output directory: ${OutputDirectory}"

echo "Deleting existing thumb files..."
rm ${OutputDirectory}/*.jpeg

/usr/local/bin/ffmpeg -i ${FileName} -r ${Rate} -s 80*80 -f image2 ${OutputDirectory}/${ThumbBaseName}-Thumb-%03d.jpeg

NumFiles=`ls -la ${OutputDirectory}/*.jpeg | wc -l`

echo "Number of thumb files generated: ${NumFiles}"
