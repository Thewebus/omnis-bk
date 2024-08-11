<?php

use App\Models\AnneeAcademique;

if(! function_exists('prefixActive')){
	function prefixActive($prefixName)
	{ 
		return	request()->route()->getPrefix() == $prefixName ? 'active' : '';
	}
}

if(! function_exists('prefixBlock')){
	function prefixBlock($prefixName)
	{ 
		return	request()->route()->getPrefix() == $prefixName ? 'block' : 'none';
	}
}

if(! function_exists('routeActive')){
	function routeActive($routeName)
	{ 
		return	request()->routeIs($routeName) ? 'active' : '';
	}
}

function setSelectedAnneeAcademique(AnneeAcademique $anneeAcademique) {
	session()->put('selectedAnneeAcademique', $anneeAcademique);
}

function getSelectedAnneeAcademique() {
	return session()->get('selectedAnneeAcademique');
}

function getLastAnneeAcademique() {
	return session()->get('lastAnneeAcademique');
}