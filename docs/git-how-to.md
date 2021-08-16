# Using git CMS for Version Control

By Robin Rowe

Git synchronizes project files so local files match what’s on the git server. It tracks changes and keeps backup files. Used correctly, it makes project management of files a breeze.

There are a handful of git commands we use daily. Don't get carried away studying git. Because it's powerful, there are whole books on git and loads of git advice on the Internet. Most of that is unnecessary and will be confusing to new users. Avoid getting caught up in git trivia and special cases. 

For the everyday basics, git is simple to use. Can be learned in a few minutes from reading this how-to...

## Install git bash Shell

The github web interface is convenient when making small changes. Real git users use the shell.

https://git-scm.com/downloads

Download a git CLI (Command Line Interface) bash shell client (not a git GUI client). If we're on 64-bit Windows, download the 64-bit git version. If that doesn't work, we need the 32-bit version. Or MacOS. Or Linux. 

During Windows installation, we specify we want full UNIX compatibility. Yes, we are sure.

## Git ssh Password Key

If using Windows 10, the OS will remember our git password for us. It isn't necessary to create a ssh key ourself, although it certainly will work that way too and may be more secure. In Windows, if we make a mistake entering our password the first time or change passwords, we will need to dig into Windows control panel settings to change it. Windows won't automatically pop up a prompt to fix a password problem like it does to ask to save our password the first time.

This how-to explains how to create git keys manually if our OS doesn't save passwords for us or we don't like the way the OS does it:

https://docs.gitlab.com/ce/ssh/README.html

Depending upon the security settings of our repo, it may require the more secure but complicated password keys setup.

## Cloning a Repo for the First Time

For setup the first time, we need to clone the repo to create a local copy. In the git shell:

    git clone https://github.com/WHOAcademy/mass-casualty.git
	cd mass-casualty
    git config user.name "Your Name"
    git config user.email "Your.Name@somewhere.com"

We only need to clone a project once. That will create a local directory with the name of the repo we just cloned. It contains a copy of all the repository's files. 

Avoid using git config --global as other how-tos suggest, unless we're sure we will never have two repos that we will want to track using two different email addresses (perhaps because one repo is for work and another is a personal pet project).

## Basic git Commands

	git status
	git add -A
	git commit -a -m "Description of our changes"
	git pull
	git push

To avoid making mistakes, it's prudent to check first with 'git status' before doing any git add, commit or push commands.

Doing a git add -A will add _everything_ we've added to the local git repo directories. Files not added yet in git are what git status calls "untracked" files. There shouldn't be any when we're done. 

It is good practice to commit and push changes at the end of each work day. If making a lot of changes during the day, we'll commit multiple times per day. Every commit is a checkpoint, a backup that we can easily undo all later changes to get back to what we had at that point in time.

When we git push, our changes are copied to the remote server. However, we must call git pull before git push so any changes on the remote server that others have pushed are brought local first, that we have the latest before uploading our changes.

## Useful git Tips

Temporary files that we don't want tracked by git can be specified (with wildcards) in the .gitignore settings file.

There's no explicit git command to create or remove a directory. Until we put files in a directory, git will ignore it.

When we want to rename or move a tracked file, we use the git mv command. 

	git mv old-file-name new-file-name
	
If we have large binary files (best not), we may want to note them in the .gitattributes settings file. Marking binary files as binary tells git to not bother trying to diff them.

There are many more git commands that are used to undo mistakes, such as adding a whole bunch of files that don't belong in the repo. Until we make a mistake with git, it's not necessary to study those commands. The most common mistake is to do a git commit without checking first with git status. 

## git log

	git log --pretty=format:"%Cgreen%<(7)%aN%Cred%d %Creset%s %ad" > git.log

## To Undo a git Commit Flub

	git commit -m "Something terribly misguided" 
	git reset HEAD~     

Back to where we were before commit.

## Merges

When two individuals change the same file, doing a git pull will trigger git into a merge state. If the changes are in separate parts of the same file, git can figure out how to handle that. If the changes overlap, we will need to edit the effected files manually to resolve merge conflicts.

A merge situation can drop us into the vi editor. For anyone unfamiliar with the vi editor's cryptic commands, this can feel alarming. What is happening is git is anticipating we may want to type in a few notes about what we did to fix a merge. We don't need any merge notes typically. Simply press :q (quit) to get out of vi. If we do write merge notes, either save them with :wq (write quit) or discard notes with :q!. The escape key then colon key switches vi into command mode.

## Lost Repo?

Confused? Forgot where we cloned a repo on a local drive? To look for a git repo, search for a directory that contains a .git directory.

Still can't find it? Simply clone it again, and this time remember where we put it! ;-)

## Create Github Access Token

Need this to push changes to your github repo...

1. In the upper-right corner of any page, click your profile photo, then click Settings
1. In the left sidebar, click Developer settings
1. In the left sidebar, click Personal access tokens
1. Click Generate new token
1. Set name in Token description field
1. Set expiration
1. Check repo in scope settings
1. Click Generate token
1. Copy and save token string somewhere safe, not in your repo!

## To git push

Enter your Github username when prompted. When asked for your password, paste your access token string.

https://docs.github.com/en/github/authenticating-to-github/keeping-your-account-and-data-secure/creating-a-personal-access-token

---00---
