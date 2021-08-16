# MCARE Globalization

by Robin Rowe 2021/8/4

Games and feature films are often presented in multiple languages to suit local audiences. For example, the hit Disney film _Frozen_ is dubbed in 41 languages.

https://www.latimes.com/entertainment/movies/la-xpm-2014-jan-24-la-et-mn-frozen-how-disney-makes-a-musical-in-41-languages-20140124-story.html

Globalization is a design approach that minimizes the development work required to customize a product for a local market.  

Internationalization (abbreviated i18n) is the process of removing local language from a product. In the motion picture industry, a film so prepared is called an M.E. Such a film isn't silent. It has sound effects and environmental sounds, but no words. 

Localization (abbreviated l10n) is the process of adding support for a local language to a product. In film editorial that means dubbing and subtitles. 

## gettext

Games and software are globalized too, but work a bit differently than film. A popular tool to organize the translation of text strings in a program (game or software) is gettext.

https://en.wikipedia.org/wiki/Gettext

The concept of gettext is every program string outputted is enclosed in the underbar function in the source code:

	printf(_("hello world"));
	
The function _() calculates a hash of the English string, then applies it to a lookup table for the language desired. The printf() function receives the translation which is output instead of the English version. This system is powerful in that it can change languages on the fly. The user can pick the language preferred, and often that choice is saved in a personal preferences file. 

The gettext string translations are produced ahead of time for each language supported, typically by hand by human translators. There are gettext tools to generate and manipulate .po files to contain translations.

Gettext has limitations that make it not ideal for MCARE. Rather than use gettext, we will use similar tools that are more robust in verifying strings have been translated and that output generic Excel CSV files rather than the obscure .po format.

## Text Strings Translation Process

1. Programmers enclose every string output call with an underbar function.
1. A tool extracts all the underbar strings, hashes them, and stores them in a CSV file with columns for Hash, String, Context. Every other row in this file is blank. 
1. The translator renames the CSV file to the language desired, such as French-MCARE.csv.
1. In Excel, the translator enters the local language translation beneath the English string.

When the payer chooses "French" as the local language, the French-MCARE.csv translations are enabled and the program switches to output in French. Each player may be in a different language in the same game.

## Audio Files Translation Process

Where environmental sounds are language specific, such as, "Paging doctor Smith!"), these will be translated and dubbed per localization. The audio file paging-doctor.mp3 swapped at game time with French-paging-doctor.mp3. Each player hearing the PA call in his or her own local language.

## Chat Translation Process

Players will have the option of leaving chat as is, or turning on machine translation which may imperfectly convert the chat to local language.

## IVR Translation Process

Players choose their language during on-boarding. Interactive Voice Response (IVR) text commands are previously converted by translators as text to the player's language. The player speaks each of the IVR commands (currently 32 words) during a training session. These IVR commands in the player's own voice are recorded and stored. Used at game time by MCARE to match voice commands from that user.

## Dictation

Players may use speech recognition to speak into chat sessions. Machine translation may be enabled.

## TTS Text-to-Speech

TTS may be used to output chat text as audio. Machine translation may be enabled.

## Multi-modal Translation

MCARE is a multi-modal interface with gaze, gesture, speech, audio and touchpad on AR. Players not wearing AR glasses can access through a mobile or computer interface, may have keyboards and mice. 

## Disabled Players Support

Blind players will not be excluded. A blind player may not be able to be a doctor, but could play in a support or admin role. For example, as an emergency phone operator (911 in the U.S.). For blind players, TTS will speak the significant events happening in the visual interface. A familiar experience to those who have used screen readers. The multi-modal touch interface to output to a braille reader.

https://www.computerhope.com/jargon/b/braille-reader.htm

Paralyzed players will not be excluded. Will be able to play using gaze. 

## Translation Logistics

We have in-house translation support for translating six languages: Arabic, Chinese, English, French, Russian and Spanish. 3 days to turn around an IVR translation, unless it's rush. 2 weeks lead time for us to engage an outsource translation team for an unsupported language, plus the time to do translation.
