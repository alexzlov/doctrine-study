<?php

class CustomDataProvider extends CArrayDataProvider
{
    protected function calculateTotalItemCount()
    {
        return $this->totalItemCount;
    }
}