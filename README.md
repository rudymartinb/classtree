# ClassTree

Description: tool for php7 code scanning. 
The final goal is to be able to create a class diagram (PNG or JPG) based on source code statements and parameters and return values types from methods and functions. By doing that you get a map of how your project is built.

## STATUS:   
**classes and Interfaces are shown with the name of each one.** 
Under development.-

## Example Image:
![sample](https://raw.githubusercontent.com/rudymartinb/classtree/master/documentation/example.png)

## Intended enviroment:  
bash under Linux.

## Requieres:

PHP7+

## Install instructions:  

	# I recommend to run this from any directory inside $HOME, like ~/usr or ~/var, to prevent polluting $HOME, but it's your call
	cd
	mkdir usr
	cd usr
	git clone git@github.com:rudymartinb/classtree.git 
	cd classtree/scripts
	./install.sh
	
It will create a ~/bin directory, a symlink to the classtree.sh located at the bin directory and then add a line to your .bash_profile which includes de ~/bin to your PATH enviroment.

to uninstall simply remove the line added to your .bash_profile, the project directory and the symlink.

## Usage:

Syntax:

	classtree <sources_path> <output_image_file.png>
	
for simplicity it's recommended to run from your project source dir:

	classtree ./ /tmp/output.png	

## Known bugs:
* may not work under software containers: project need access read-only access to the filesystem and it's own files to be able to load them, and read-write to the indicated outputfile.-
* duplicated names (class, interfaces, etc) among different namespaces will produce underisable results.
* most likely won't work on files with mixed html and php code (btw html data should be separated into another file).
* this project relies heavly on regular expressions, as such there might be some edge cases I may have overlooked. If you run into a such situation let me know, if possible with copies of the scanned source files that gave you problems.
* ATM only Unix linefeed is used for lines break.
* Anonymous classes, anonymous functions, macros and functions outside classes are not going to be considered while building the dependencies tree.
* installing the project from the script more than once will create several repeated lines at the end of ~/.bash_profile.
* no error reporting yet.
* just png at the moment.
* arrow head calculation needs some tweak.-

## Next steps: 
* heavy refactor of tree_build.
* adding access modifiers and functions for classes diagram nodes.
* adding functions for interfaces diagram nodes.
* allow to separate each tree in several images with the implemented interfaces togheter.  
 
## Testing:  
take a look at scripts/testphp.sh, modify if neccesary then run from the project's root directory:

	./scripts/runtests.sh

it's recommended to use a terminal with color support like konsole.-


