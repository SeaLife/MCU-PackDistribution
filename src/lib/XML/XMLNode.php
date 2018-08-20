<?php

namespace XML;

interface XMLNode {
    public function getName ();

    public function getAttributes ();

    public function getContent ();
}