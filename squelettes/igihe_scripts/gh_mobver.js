function iPhoneAlert() 
{
	if(
	   	(navigator.userAgent.match(/iPhone/i))
		||(navigator.userAgent.match(/iPod/i))
		)
	{
	var question = confirm("Urifuza kureba IGIHE.COM ukoresheje MOBILE Version kuri IPHONE yawe?")
		if (question)
		{window.location = "http://igihe.com/spip.php?cimobile=smarthphone";	}
		else{}
	}
};
function BlackBerryAlert() 
{
	if(
		(navigator.userAgent.match(/BlackBerry/i))
		||(navigator.userAgent.match(/HTC/i))
		)
	{
	var question = confirm("Urifuza kureba IGIHE.COM ukoresheje MOBILE Version kuri SMARTPHONE yawe?")
		if (question)
		{window.location = "http://igihe.com/spip.php?cimobile=smarthphone";	}
		else{}
	}
};

function MobileAlert() 
{
	if(
		(navigator.userAgent.match(/Nokia/i)) 
		||(navigator.userAgent.match(/Samsung/i))
		||(navigator.userAgent.match(/LG/i))
		||(navigator.userAgent.match(/MOT/i))
		||(navigator.userAgent.match(/SonyEricsson/i))
		)
	{
	var question = confirm("Urifuza kureba IGIHE.COM ukoresheje MOBILE Version kuri MOBILE yawe?")
		if (question)
		{window.location = "http://igihe.com/spip.php?cimobile=smarthphone";	}
		else{}
	}
}