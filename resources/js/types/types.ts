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
    id_var:number
    nome: string;
    valor: number;
}


export interface Categoria{
    id: number,
    titulo: number
}
