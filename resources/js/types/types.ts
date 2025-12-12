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
    titulo: number;
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
