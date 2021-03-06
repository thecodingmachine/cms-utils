<?php


namespace TheCodingMachine\CMS\Utils;


class ContextMerger implements ContextMergerInterface
{
    /**
     * Merges 2 contexts in a custom way.
     *
     * @param mixed[] $context1
     * @param mixed[] $context2
     * @return mixed[]
     */
    public function mergeContexts(array $context1, array $context2): array
    {
        $finalContext = $context1;
        foreach ($context2 as $key => $value) {
            if (is_numeric($key)) {
                $finalContext[] = $value;
                continue;
            }

            if (isset($finalContext[$key]) && is_array($finalContext[$key]) && is_array($value)) {
                $finalContext[$key] = $this->mergeContexts($finalContext[$key], $value);
                continue;
            }
            $finalContext[$key] = $value;
        }
        return $finalContext;
    }
}