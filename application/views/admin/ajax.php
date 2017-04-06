<?php

if (!isSet($save))
	{
	echo '<save>uwaga, operacja NIE została przeprowadzona</save>'."\n";
	}
	else
	{
	echo '<save>OK</save>'."\n";
	}

if (!isSet($error))
	{
	echo '<error>OK</error>'."\n";
	}
	else
	{
	echo '<error>'.$error.'</error>'."\n";
	}

if (!isSet($alert))
	{
	echo '<alert>OK</alert>'."\n";
	}
	else
	{
	echo '<alert>'.$alert.'</alert>'."\n";
	}

if (isSet($output))
	{
	echo '<output><![CDATA['.$output.']]></output>'."\n";
	}

if (isSet($outputC))
	{
	echo $outputC;
	}

if (isSet($dane))
	{
	echo $dane;
	}
