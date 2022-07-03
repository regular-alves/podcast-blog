<?php

namespace SimpleImporter\Controller;

class Taxonomies 
{
  public function __construct()
  {
    new Taxonomies\PodcastGenre();
    new Taxonomies\PodcastCountry();
    new Taxonomies\PodcastPublisher();
    new Taxonomies\PodcastLanguage();
    new Taxonomies\PodcastType();
  }
}