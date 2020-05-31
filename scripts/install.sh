#!/bin/bash
if [ ! -f ../bin/classtree.sh ] ; then
	echo "This script must be run from the script directory inside the project files"
	exit
fi

clear
echo This script will:
echo "1: create a ~/bin dir (if it doesn't exist)"
echo "2: create a symlink named \"classtree\" inside to the main script"
echo "3: update/create ~/.bash_profile to add ~/bin to your PATH enviroment"
echo ""
echo "press Enter to continue, Ctrl-C to abort"
read >/dev/null 

echo "Installing ..." 
mkdir ~/bin 2>/dev/null

# TODO: test if we really need to do this if installed twice
echo "export PATH=\$PATH:~/bin:" >>~/.bash_profile
chmod +x ../bin/classtree.sh
rm -f ~/bin/classtree
cd ../bin
ln -s $(pwd)/classtree.sh ~/bin/classtree

# done !
echo "" 
echo All done!
echo Now you can run \"classtree\" from your project
echo ie: 
echo "" 
echo classtree . /tmp/output.jpg