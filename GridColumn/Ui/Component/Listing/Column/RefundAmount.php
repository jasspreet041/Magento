<?php

namespace ForeverCompanies\GridColumn\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class RefundAmount extends Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['refund_amount'])) {
                    $item['refund_amount'] = number_format($item['refund_amount'], 2);
                }
            }
        }

        return $dataSource;
    }
}