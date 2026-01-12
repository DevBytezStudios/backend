export interface Confeitaria{
    id: number,
    nome: string,
    slug: string,
    logo: string,
    cor_princ: string,
    cor_sec: string,
    email: string
}


export interface Produto {
    id: number;
    nome: string;
    descricao: string;
    valor: number;
    valor_desc: number;
    imagem: string;
    categoria: Categoria | null;
}

export interface Variacao {
    id: number;
    id_produto: number;
    titulo: string;
    opcoes: Opcao[] | null;
}

export interface Opcao {
    id: number;
    id_var: number;
    nome: string;
    valor: number;
}

export interface Categoria {
    id: number;
    titulo: string;
}

export interface PaginatorLink {
    url: string;
    label: string;
    active: boolean;
    page: number;
}

export interface Paginator {
    current_page: number;
    data: [];
    first_page_url: string;
    from: number | null;
    last_page: number;
    last_page_url: string;
    links: PaginatorLink[];
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number | null;
    total: number;
}


// PEDIDOS
export interface Pedido{
    id: number,
    id_con: number,
    cliente: Cliente,
    pagamento: string,
    code: string,
    data: Date,
    pedidoItem: PedidoItems[]
    total: number,
    status: string,
}

export interface Cliente{
    id: number,
    nome: string,
    telefone: string,
    cep: string,
    rua: string,
    numero: number,
    complemento: string,
    bairro: string,
    cidade:string,
}

export interface PedidoItems{
    id: number,
    id_pedido: number,
    produto: ProdutoPedido,
    opcoes:OpcaoPedido[],
    quantidade: number
}

export interface ProdutoPedido {
    id: number;
    nome: string;
    valor: number;
    valor_desc: number;
}

export interface OpcaoPedido{
    id:number,
    valor: number,
    nome: string
}


// CONFIGURAÇÂO ENCOMENDAS
export interface Etapa{
    id: number,
    id_con:number,
    nome: string,
    ordem: number,
    required: boolean,
    multiple: boolean,
    icone: string
}

export interface OpcaoEtapa{
    id: number,
    etapa:{
        id: number,
        nome: string,
    }
    nome: string,
    valor: number,
    descricao: string,
    active:boolean
}

export interface Estilo{
    id: number,
    id_con: number,
    titulo: string,
    valor: number,
    imagem: string,
    descricao: string,
    active: boolean
}

// ENCOMENDAS

export interface Encomenda{
    id: number,
    cliente: Cliente
    id_con: number,
    observacao: string,
    data_entrega: Date,
    pagamento: string,
    status: string,
    code:string
    opcoes: EncomendaOpcoes[]
    estilo:{
        titulo: string,
        imagem: string,
        valor: number
    }
}

export interface EncomendaOpcoes{
    id: number,
    id_encomenda: number,
    etapa: string,
    nome: string,
    valor: number
}
