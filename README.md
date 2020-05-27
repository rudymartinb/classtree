# ClassTree

Description: tool for php7 code scanning. 
The final goal is to be able to create a class diagram (PNG or JPG) based on source code statements and parameters and return values types from methods and functions. By doing that you get a map of how your project is built.

STATUS: Under development.- Comments are welcome!

Intended enviroment: bash under Linux.

Install instructions:

clone the git and execute install.sh on scritps directory. 
It will create a ~/bin directory, a symlink to the classtree.sh located at the bin directory and then add a line to your .bash_profile which includes de ~/bin to your PATH enviroment.

to uninstall simply remove the line added to your .bash_profile, the project directory and the symlink.

Testing:
take a look at scripts/testphp.sh, modify if neccesary then run from the project's root directory:

./scripts/runtests.sh

it's recommended to use a terminal with color support.


Known bugs: 
* most likely won't work on files with mixed html and php code (btw html data should be separated into another file).
* this project relies heavly on regular expressions, as such there might be some edge cases I may have overlooked. If you run into a such situation let me know, if possible with copies of the scanned source files that gave you problems.
* ATM only Unix linefeed is used for lines break
* Anonymous classes, anonymous functions, macros and functions outside classes are not going to be considered while building the dependencies tree. Just classes, interfaces and namespaces for now, at least at first. I plan to include traits later.
* installing the project from the script more than once will create several repeated lines at the end of ~/.bash_profile
 