# ClassTree

Description: tool for php7 code scanning. 
The final goal is to be able to create a class diagram (PNG or JPG) based on source code statements and parameters and return values types from methods and functions.
So far it's able to create text files with classes hierarchy ONLY.-

STATUS: Alpha. Under development.- Comments are welcome! (see progress.txt under "documentation")

Intended enviroment: bash under Linux.

Install instructions:

clone the git and execute install.sh on scrtips directory. 
It will create a ~/bin directory, a symlink to the classtree.sh located at the bin directory and then add a line to your .bash_profile which includes de ~/bin to your PATH enviroment.

Update: removed textoutput while working with graphics 

Testing:
take a look at scripts/testphp.sh, modify if neccesary then run from the project root directory:

./scripts/runtests.sh

 