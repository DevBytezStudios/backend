export interface Produto {
    id: number;
    nome: string;
    descricao: string;
    valor: number;
    valorDesc: number;
    imagem: string;
    categoria: string;
}

export interface Variacao {
    id: number;
    titulo: string;
    opcoes: Opcao[] | null;
}

export interface Opcao {
    id: number;

    titulo: string;
    valor: number;
}
