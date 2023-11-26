<p>Test</p>

{{-- @component('components.increment', ["num" => 1]) @endcomponent --}}
{{-- @component('components.increment') @endcomponent --}}

@php
    // enum FormAttributes {
    //     case REQUEIRED;
    // };

    $form = [
        "username" => []
    ];
@endphp

<form method="post" novalidate>
    <label>
        Username
        <input type="email" name="username" required>
    </label>
    <label>
        Password
        <input type="password" name="password">
    </label>
    <input type="submit">
</form>