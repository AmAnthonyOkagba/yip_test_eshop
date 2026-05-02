<h1>Welcome to E-Shop (Smarty Template Example)</h1>
<p class="text-muted">This is a demonstration of Smarty template integration with Laravel.</p>

<div class="row mt-5">
    <div class="col-md-8">
        <h3>Featured Products</h3>
        {if $products|@count > 0}
            <div class="row">
                {foreach $products as $product}
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{$product->name}</h5>
                                <p class="card-text text-muted">{$product->description|truncate:80}</p>
                                <div class="price" style="font-size: 1.5rem; color: #0d6efd; font-weight: bold;">
                                    ${$product->price|string_format:"%.2f"}
                                </div>
                                <div class="mt-3">
                                    {if $product->stock > 0}
                                        <a href="/products/{$product->id}" class="btn btn-primary">View Details</a>
                                    {else}
                                        <button class="btn btn-secondary" disabled>Out of Stock</button>
                                    {/if}
                                </div>
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
        {else}
            <div class="alert alert-info">
                <p>No products available at the moment.</p>
            </div>
        {/if}
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">About Smarty Integration</h5>
            </div>
            <div class="card-body">
                <p>This template demonstrates Smarty template engine integration with Laravel.</p>
                <ul>
                    <li>Template syntax: {ldelim}{rdelim}</li>
                    <li>Variable assignment: {ldelim}$variable{rdelim}</li>
                    <li>Loops: {ldelim}foreach{rdelim}</li>
                    <li>Conditionals: {ldelim}if{rdelim}</li>
                    <li>Modifiers: {ldelim}$var|modifier{rdelim}</li>
                </ul>
                <p><small>Learn more at: <a href="https://www.smarty.net/" target="_blank">smarty.net</a></small></p>
            </div>
        </div>
    </div>
</div>
