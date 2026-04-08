
// ── NAVIGATION ──
const bcs={
  dashboard:'Home &rsaquo; <span>Dashboard</span>',
  produtos:'Home &rsaquo; <span>Todos os Produtos</span>',
  pedidos:'Home &rsaquo; <span>Lista de Pedidos</span>',
  usuarios:'Home &rsaquo; <span>Usuários Cadastrados</span>',
  adicionar:'Home &rsaquo; <span>Adicionar Produto</span>',
};
function goto(id,el){
  document.querySelectorAll('.screen').forEach(s=>s.classList.remove('active'));
  document.getElementById('screen-'+id).classList.add('active');
  document.querySelectorAll('.nav-item').forEach(n=>n.classList.remove('active'));
  if(el) el.classList.add('active');
  document.getElementById('breadcrumb').innerHTML=bcs[id]||'';
}
function closeModal(id){document.getElementById(id).classList.add('hidden')}

// ── SIZES ──
const SIZES=['PP','P','M','G','GG','38','39','40','41','42','43'];
function buildSizeGrid(id,sel=[]){
  const el=document.getElementById(id); el.innerHTML='';
  SIZES.forEach(s=>{
    const d=document.createElement('div');
    d.className='size-tag'+(sel.includes(s)?' selected':'');
    d.textContent=s;
    d.onclick=()=>d.classList.toggle('selected');
    el.appendChild(d);
  });
}
buildSizeGrid('sizeGrid');
buildSizeGrid('epSizeGrid');
function getSelSizes(id){return[...document.querySelectorAll('#'+id+' .size-tag.selected')].map(t=>t.textContent)}

// ── DONUT CHARTS ──
const donuts=[{val:81,label:'Pedido Total',color:'#e05252',bg:'#fdecea'},{val:22,label:'••••••••',color:'#2e9e5b',bg:'#eaf4ee'},{val:62,label:'Receita Total',color:'#3a7bd5',bg:'#eaf0f8'}];
donuts.forEach(d=>{
  const r=50,cx=60,cy=60,circ=2*Math.PI*r,dash=(d.val/100)*circ;
  document.getElementById('donutRow').innerHTML+=`<div class="donut-wrap">
    <svg class="donut-svg" width="120" height="120" viewBox="0 0 120 120">
      <circle cx="${cx}" cy="${cy}" r="${r}" fill="none" stroke="${d.bg}" stroke-width="14"/>
      <circle cx="${cx}" cy="${cy}" r="${r}" fill="none" stroke="${d.color}" stroke-width="14" stroke-dasharray="${dash} ${circ}" stroke-linecap="round"/>
      <text x="${cx}" y="${cy}" text-anchor="middle" dominant-baseline="central" transform="rotate(90,${cx},${cy})" font-family="Cinzel,serif" font-size="17" font-weight="700" fill="${d.color}">${d.val}%</text>
    </svg>
    <div class="donut-label">${d.label}</div></div>`;
});

// ── MAIS VENDIDOS ──
for(let i=0;i<3;i++) document.getElementById('maisVendidos').innerHTML+=`
  <div class="sold-item">
    <div class="sold-thumb">👟</div>
    <div class="sold-info"><div class="sold-name">Adidas Ultra boost</div><div class="sold-sku">R$126.500</div></div>
    <div style="text-align:right"><div class="sold-price">R$126,50</div><div class="sold-sales">999 vendas</div></div>
  </div>`;

// ── AREA CHART ──
const months=['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
const vals=[320,410,380,520,456,600,540,480,610,700,650,720];
months.forEach(m=>document.getElementById('chartLabels').innerHTML+=`<span>${m}</span>`);
const ce=document.getElementById('areaChart');
const W=ce.offsetWidth||860,H=140;
const mx=Math.max(...vals),mn=Math.min(...vals);
const pts=vals.map((v,i)=>[(i/(vals.length-1))*W,H-((v-mn)/(mx-mn))*(H-26)-8]);
const pd=pts.map((p,i)=>i===0?`M${p[0]},${p[1]}`:`S${p[0]-28},${p[1]} ${p[0]},${p[1]}`).join(' ');
ce.innerHTML=`<svg width="100%" height="${H}" viewBox="0 0 ${W} ${H}" preserveAspectRatio="none" style="display:block">
  <defs><linearGradient id="ag" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#61c94cff" stop-opacity=".16"/><stop offset="100%" stop-color="#4cc956ff" stop-opacity="0"/></linearGradient></defs>
  <path d="${pd} L${W},${H} L0,${H} Z" fill="url(#ag)"/>
  <path d="${pd}" fill="none" stroke="#4cc95dff" stroke-width="2.2" stroke-linecap="round"/>
  <circle cx="${pts[4][0]}" cy="${pts[4][1]}" r="5" fill="#4cc952ff" stroke="white" stroke-width="2"/>
  <rect x="${pts[4][0]-36}" y="${pts[4][1]-34}" width="80" height="28" rx="5" fill="white" stroke="#92e88aff" stroke-width="1"/>
  <text x="${pts[4][0]+3}" y="${pts[4][1]-20}" fill="#4cc94cff" font-family="Cinzel,serif" font-size="12" font-weight="700">456</text>
  <text x="${pts[4][0]+3}" y="${pts[4][1]-7}" fill="#999" font-family="Outfit,sans-serif" font-size="10">Pedidos</text>
  <text x="${pts[4][0]-31}" y="${pts[4][1]-7}" fill="#bbb" font-family="Outfit,sans-serif" font-size="9">Mai 2025</text>
</svg>`;

// ── DATA ──
const pedidosData=[
  {prod:'Adidas Ultra boost',id:'#25426',data:'08/03/2026',metodo:'Cartão',cliente:'Ikaro',status:'Entregue',valor:'R$200,00',ini:'IK'}
];
function sb(s){return s==='Delivered'?'badge-blue':s==='Canceled'?'badge-gold':'badge-gray'}

pedidosData.slice(0,6).forEach(p=>document.getElementById('recentBody').innerHTML+=`<tr>
  <td><input type="checkbox" class="chk"></td>
  <td><strong>${p.prod}</strong></td><td style="color:var(--text3);font-size:12px">${p.id}</td>
  <td style="color:var(--text3)">${p.data}</td>
  <td><span class="avatar-sm">${p.ini}</span>${p.cliente}</td>
  <td><span class="badge ${sb(p.status)}">${p.status}</span></td>
  <td style="font-weight:700;color:var(--gold)">${p.valor}</td></tr>`);

pedidosData.forEach(p=>document.getElementById('pedidosBody').innerHTML+=`<tr>
  <td><input type="checkbox" class="chk"></td>
  <td><strong>${p.prod}</strong></td><td style="color:var(--text3);font-size:12px">${p.id}</td>
  <td style="color:var(--text3)">${p.data}</td><td style="color:var(--text2)">${p.metodo}</td>
  <td><span class="avatar-sm">${p.ini}</span>${p.cliente}</td>
  <td><span class="badge ${sb(p.status)}">${p.status}</span></td>
  <td style="font-weight:700;color:var(--gold)">${p.valor}</td></tr>`);

const pag=document.getElementById('pagination');
[1,2,3,4,'…',10].forEach((n,i)=>pag.innerHTML+=`<div class="page-btn${i===0?' active':''}">${n}</div>`);
pag.innerHTML+=`<div class="page-btn" style="padding:0 14px">NEXT ›</div>`;

// ── USERS ──
let users=[
  {nome:'Ikaro',email:'ikarofeio@gmail.com',tel:'(11) 98888-1111',metodo:'Cartão',status:'Entregue'}
];
let editUserIdx=-1;

function renderUsers(){
  const ub=document.getElementById('usersBody'); ub.innerHTML='';
  document.getElementById('userCount').textContent=users.length+' cadastrados';
  users.forEach((u,i)=>{
    const ini=u.nome.split(' ').map(x=>x[0]).join('').slice(0,2).toUpperCase();
    ub.innerHTML+=`<tr>
      <td><span class="avatar-sm">${ini}</span><strong>${u.nome}</strong></td>
      <td style="color:var(--text2)">${u.email}</td>
      <td style="color:var(--text3)">${u.tel}</td>
      <td style="color:var(--text2)">${u.metodo}</td>
      <td><span class="badge ${sb(u.status)}">${u.status}</span></td>
      <td style="display:flex;gap:6px;align-items:center">
        <button class="btn btn-edit btn-sm" onclick="openUserModal(${i})">✏️ Editar</button>
        <button class="btn btn-red btn-sm" onclick="delUser(${i})">🗑️</button>
      </td></tr>`;
  });
}
renderUsers();

function openUserModal(idx){
  editUserIdx=idx;
  if(idx>=0){
    const u=users[idx];
    document.getElementById('userModalTitle').textContent='Editar Usuário';
    document.getElementById('u-nome').value=u.nome;
    document.getElementById('u-email').value=u.email;
    document.getElementById('u-tel').value=u.tel;
    document.getElementById('u-metodo').value=u.metodo;
    document.getElementById('u-status').value=u.status;
    document.getElementById('userSaveBtn').textContent='Salvar Alterações';
  } else {
    document.getElementById('userModalTitle').textContent='Novo Usuário';
    ['u-nome','u-email','u-tel'].forEach(id=>document.getElementById(id).value='');
    document.getElementById('u-metodo').value='PayPal';
    document.getElementById('u-status').value='Delivered';
    document.getElementById('userSaveBtn').textContent='Salvar Usuário';
  }
  document.getElementById('userModal').classList.remove('hidden');
}
function saveUser(){
  const obj={nome:document.getElementById('u-nome').value||'Novo Usuário',email:document.getElementById('u-email').value||'—',tel:document.getElementById('u-tel').value||'—',metodo:document.getElementById('u-metodo').value,status:document.getElementById('u-status').value};
  if(editUserIdx>=0) users[editUserIdx]=obj; else users.push(obj);
  renderUsers(); closeModal('userModal');
}
function delUser(i){if(confirm('Excluir "'+users[i].nome+'"?')){users.splice(i,1);renderUsers()}}

// ── PRODUCTS ──
let products=[
  {name:'Adidas Ultra boost',cat:'Tênis',price:'R$610,40',icon:'👟',vendas:1269,estoque:1269,sizes:['38','40','42'],desc:'Corridas de longa distância exigem muito dos atletas.'},
  {name:'Adidas Ultra boost',cat:'Tênis',price:'R$600,40',icon:'👟',vendas:1269,estoque:1269,sizes:['P','M','G'],desc:'Corridas de longa distância exigem muito dos atletas.'},
  {name:'Adidas Ultra boost',cat:'Tênis',price:'R$800,40',icon:'👟',vendas:1269,estoque:1269,sizes:['36','38','40'],desc:'Corridas de longa distância exigem muito dos atletas.'},
  {name:'ADIZERO SL RUNNING',cat:'Corrida',price:'R$364,40',icon:'🏃',vendas:1269,estoque:1269,sizes:['M','G','GG'],desc:'Corridas de longa distância exigem muito dos atletas.'},
  {name:'ULTRABOOST CLEATS',cat:'Tênis',price:'R$800,40',icon:'⚽',vendas:1269,estoque:1269,sizes:['40','42','44'],desc:'Corridas de longa distância exigem muito dos atletas.'},
  {name:'FORUM EXHIBIT LOW',cat:'Tênis',price:'R$674,00',icon:'👟',vendas:109,estoque:1500,sizes:['38','40'],desc:'Corridas de longa distância exigem muito dos atletas.'},
  {name:'Adidas Ultra boost',cat:'Tênis',price:'R$710,40',icon:'👟',vendas:1269,estoque:1269,sizes:['P','M'],desc:'Corridas de longa distância exigem muito dos atletas.'},
  {name:'Adidas Ultra boost',cat:'Tênis',price:'R$600,40',icon:'👟',vendas:1269,estoque:1269,sizes:['G','GG'],desc:'Corridas de longa distância exigem muito dos atletas.'},
  {name:'Adidas Ultra boost',cat:'Tênis',price:'R$800,40',icon:'👟',vendas:1269,estoque:1269,sizes:['36','38','40','42'],desc:'Corridas de longa distância exigem muito dos atletas.'},
];
let editProdIdx=-1, deleteProdIdx=-1;

function renderProducts(){
  const pg=document.getElementById('prodGrid'); pg.innerHTML='';
  products.forEach((p,i)=>{
    const vP=Math.min(100,(p.vendas/1500)*100), rP=Math.min(100,(p.estoque/1500)*100);
    const szTags=p.sizes.map(s=>`<span style="display:inline-block;padding:2px 7px;border-radius:4px;border:1px solid #ddd;font-size:10px;color:#666;margin:0 2px 3px 0">${s}</span>`).join('');
    pg.innerHTML+=`<div class="product-card">
      <div class="product-img">
        <span style="font-size:44px">${p.icon}</span>
        <div class="product-actions">
          <button class="btn btn-edit btn-sm" onclick="openProdModal(${i})">✏️</button>
          <button class="btn btn-red btn-sm" onclick="openDeleteModal(${i})">🗑️</button>
        </div>
      </div>
      <div class="product-body">
        <div class="product-name">${p.name}</div>
        <div class="product-cat">${p.cat}</div>
        <div class="product-price">${p.price}</div>
        <div style="margin-bottom:7px">${szTags}</div>
        <div class="product-desc">${p.desc}</div>
        <div class="stat-row"><span class="stat-label">Vendas</span><span class="stat-arrow">↑</span><div class="stat-bar"><div class="stat-fill" style="width:${vP}%"></div></div><span class="stat-val">${p.vendas}</span></div>
        <div class="stat-row"><span class="stat-label">Prod. restantes</span><span class="stat-arrow down">—</span><div class="stat-bar"><div class="stat-fill orange" style="width:${rP}%"></div></div><span class="stat-val">${p.estoque}</span></div>
      </div></div>`;
  });
}
renderProducts();

function openProdModal(i){
  editProdIdx=i; const p=products[i];
  document.getElementById('ep-nome').value=p.name;
  document.getElementById('ep-cat').value=p.cat;
  document.getElementById('ep-preco').value=p.price;
  document.getElementById('ep-estq').value=p.estoque;
  document.getElementById('ep-desc').value=p.desc;
  buildSizeGrid('epSizeGrid',p.sizes);
  document.getElementById('prodModal').classList.remove('hidden');
}
function saveProd(){
  products[editProdIdx]={...products[editProdIdx],name:document.getElementById('ep-nome').value,cat:document.getElementById('ep-cat').value,price:document.getElementById('ep-preco').value,estoque:parseInt(document.getElementById('ep-estq').value)||0,desc:document.getElementById('ep-desc').value,sizes:getSelSizes('epSizeGrid')};
  renderProducts(); closeModal('prodModal');
}
function openDeleteModal(i){deleteProdIdx=i; document.getElementById('deleteModal').classList.remove('hidden')}
function confirmDelete(){products.splice(deleteProdIdx,1);renderProducts();closeModal('deleteModal')}

// ── ADD PRODUCT ──
function addProduct(){
  const nome=document.getElementById('p-nome').value;
  if(!nome){alert('Digite o nome do produto!');return}
  products.unshift({name:nome,cat:document.getElementById('p-cat').value||'Geral',price:document.getElementById('p-preco').value||'R$0,00',icon:'👕',vendas:0,estoque:parseInt(document.getElementById('p-estqt').value)||0,sizes:getSelSizes('sizeGrid'),desc:document.getElementById('p-desc').value||''});
  ['p-nome','p-desc','p-cat','p-marca','p-estnum','p-estqt','p-preco'].forEach(id=>document.getElementById(id).value='');
  buildSizeGrid('sizeGrid');
  renderProducts();
  goto('produtos',document.getElementById('nav-produtos'));
}

// Close modals on overlay click
['userModal','prodModal','deleteModal'].forEach(id=>{
  document.getElementById(id).addEventListener('click',function(e){if(e.target===this) closeModal(id)});
});
