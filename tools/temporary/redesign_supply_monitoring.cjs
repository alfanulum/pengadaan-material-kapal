const fs = require('fs');
const path = require('path');

const engineerPath = path.join(__dirname, 'resources', 'views', 'engineer', 'monitoring', 'index.blade.php');
const supplyPath = path.join(__dirname, 'resources', 'views', 'supply-chain', 'monitoring', 'index.blade.php');

let engContent = fs.readFileSync(engineerPath, 'utf8');
let supContent = fs.readFileSync(supplyPath, 'utf8');

// Extract the @forelse block from Engineer
const forelseRegex = /@forelse\(\$purchaseOrders as \$po\)[\s\S]*?@empty/;
let engForelse = engContent.match(forelseRegex)[0];

// Replace the route in the copied block to point to supply chain
engForelse = engForelse.replace(/route\('engineer\.monitoring\.show'/g, "route('supply-chain.monitoring.show'");

// Now replace the @forelse block in Supply Chain
supContent = supContent.replace(forelseRegex, engForelse);

fs.writeFileSync(supplyPath, supContent, 'utf8');
console.log('Supply chain monitoring updated to match Engineer.');
