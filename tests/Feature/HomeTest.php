<?php

test('testar home page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});