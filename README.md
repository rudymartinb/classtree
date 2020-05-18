# ClassTree

Description: tool for php7 code analysis. 
The goal is to be able to create a class diagram (PNG or JPG) based on source code statements and parameters and return values types from methods and functions.
So far it's able to create text files with classes hierarchy ONLY (no interfaces and namespaces ATM).-

Intended enviroment: bash under Linux.

Install instructions:

clone the git and execute install.sh on scrtips directory. 
It will create a ~/bin directory, a symlink to the classtree.sh located at the bin directory and then add a line to your .bash_profile which includes de ~/bin to your PATH enviroment.

How to use it:

classtree /path/to/project/sources /tmp/outputfile.txt


STATUS: Alpha. Under development.- Comments are welcome! (see progress.txt under "documentation")





Note:
I apologize for mixing Spanish and English, will switch it entirely to English ASAP (read: while I refactor).


 