<?php

class myDomainConfigFilter extends sfFilter
{
  /**
   * Executes the filter chain.
   *
   * @param sfFilterChain $filterChain
   */
    public function execute($filterChain)
    {
        $config = sfConfig::getAll();
        $host = sfContext::getInstance()->getRequest()->getHost();

        foreach ($config as $key => $value) {
            if ($key == 'dm_' . $host) {
                foreach ($value as $subkey => $subval) {
                    $config['dm_' . $subkey] = $subval;
                }
            }
        }

        sfConfig::clear();
        sfConfig::add($config);

        $filterChain->execute();
    }
}